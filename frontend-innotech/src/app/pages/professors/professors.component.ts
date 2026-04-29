import { Component, OnInit, OnDestroy } from "@angular/core"
import { CommonModule } from "@angular/common"
import { FormsModule } from "@angular/forms"
import { Router } from "@angular/router"
import { TranslateModule, TranslateService } from "@ngx-translate/core"
import { Subject, takeUntil, forkJoin, debounceTime, distinctUntilChanged } from "rxjs"

import { LoaderService } from "@core/services/loader.service"
import { NotificationService } from "@core/services/notification.service"
import { ProfessorService } from "@core/services/professor.service"
import { DepartmentService } from "@core/services/department.service"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { Professor } from "@core/models/professor"
import { Department } from "@core/models/department"
import { environment } from "@environments/environment"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"

@Component({
  selector: "app-professors",
  standalone: true,
  imports: [CommonModule, FormsModule, TranslateModule, LoaderComponent, PageHeaderComponent],
  templateUrl: "./professors.component.html",
  styleUrls: ["./professors.component.css"],
})
export class ProfessorsComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()
  private searchSubject = new Subject<string>()

  professors: Professor[] = []
  filteredProfessors: Professor[] = []
  departments: Department[] = []

  // Filter properties
  searchTerm = ""
  selectedDepartment = ""
  selectedSpeciality = ""
  selectedGrade = ""

  // Available filter options
  specialities: string[] = []
  grades: string[] = []

  constructor(
    private router: Router,
    private translate: TranslateService,
    private professorService: ProfessorService,
    private departmentService: DepartmentService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
  ) {
    // Setup search debouncing
    this.searchSubject
      .pipe(debounceTime(300), distinctUntilChanged(), takeUntil(this.destroy$))
      .subscribe((searchTerm) => {
        this.searchTerm = searchTerm
        this.applyFilters()
      })
  }

  ngOnInit(): void {
    this.loadData()
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  loadData(): void {
    this.loaderService.show()

    forkJoin({
      professors: this.professorService.getAllProfessors(),
      departments: this.departmentService.getAllDepartments(),
    })
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (data) => {
          this.professors = data.professors
          console.log(this.professors);
          this.departments = data.departments
          this.filteredProfessors = [...this.professors]

          // Extract unique specialities and grades for filters
          this.specialities = [...new Set(this.professors.map((p) => p.speciality))]
          this.grades = [...new Set(this.professors.map((p) => p.grade))]

          this.loaderService.hide()
        },
        error: (error) => {
          console.error("Error loading professors data:", error)
          this.loaderService.hide()
          this.notificationService.errorI18n(
            this.translate.instant("TOAST.ERROR"),
            this.translate.instant("PROFESSORS.LOAD_ERROR"),
          )
        },
      })
  }

  onSearchChange(searchTerm: string): void {
    this.searchSubject.next(searchTerm)
  }

  onFilterChange(): void {
    this.applyFilters()
  }

  applyFilters(): void {
    this.filteredProfessors = this.professors.filter((professor) => {
      const matchesSearch =
        !this.searchTerm ||
        professor.first_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        professor.last_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        professor.speciality.toLowerCase().includes(this.searchTerm.toLowerCase())

      const matchesDepartment =
        !this.selectedDepartment || professor.department_id.toString() === this.selectedDepartment

      const matchesSpeciality = !this.selectedSpeciality || professor.speciality === this.selectedSpeciality

      const matchesGrade = !this.selectedGrade || professor.grade === this.selectedGrade

      return matchesSearch && matchesDepartment && matchesSpeciality && matchesGrade
    })
  }

  clearFilters(): void {
    this.searchTerm = ""
    this.selectedDepartment = ""
    this.selectedSpeciality = ""
    this.selectedGrade = ""
    this.filteredProfessors = [...this.professors]
  }

  viewProfessorDetails(professor: Professor): void {
    this.router.navigate(["/professors", professor.profile_slug]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  getDepartmentName(departmentId: number): string {
    const department = this.departments.find((d) => d.id === departmentId)
    return department ? department.name : "Unknown Department"
  }

  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`
  }
}
