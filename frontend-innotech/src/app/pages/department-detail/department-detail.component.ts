import { Component, OnInit, OnDestroy, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { Subject, takeUntil, forkJoin } from 'rxjs';

import { LoaderService } from '@core/services/loader.service';
import { NotificationService } from '@core/services/notification.service';
import { DepartmentService } from '@core/services/department.service';
import { ProfessorService } from '@core/services/professor.service';
import { LoaderComponent } from '@shared/components/loader/loader.component';
import { Department } from '@core/models/department';
import { Professor } from '@core/models/professor';
import { environment } from '@environments/environment';

@Component({
  selector: 'app-department-detail',
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent],
  templateUrl: './department-detail.component.html',
  styleUrls: ['./department-detail.component.css']
})
export class DepartmentDetailComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>();

  // Using Angular 19 signals
  department = signal<Department | null>(null);
  professors = signal<Professor[]>([]);
  isLoading = signal<boolean>(true);
  departmentId = signal<number>(0);

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private translate: TranslateService,
    private departmentService: DepartmentService,
    private professorService: ProfessorService,
    public loaderService: LoaderService,
    private notificationService: NotificationService
  ) {}

  ngOnInit(): void {
    this.route.params.pipe(takeUntil(this.destroy$)).subscribe((params) => {
      const id = Number(params['id']);
      this.departmentId.set(id);
      if (id) {
        this.loadDepartmentData();
      }
    });
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  private loadDepartmentData(): void {
    this.isLoading.set(true);
    this.loaderService.show();

    // Load both department details and professors in parallel
    forkJoin({
      department: this.departmentService.getDepartmentById(this.departmentId()),
      professors: this.professorService.getProfessorsByDepartment(this.departmentId())
    })
    .pipe(takeUntil(this.destroy$))
    .subscribe({
      next: ({ department, professors }) => {
        this.department.set(department);
        this.professors.set(professors);
        console.log(this.professors());
        this.finishLoading();
      },
      error: (error) => {
        console.error('Error loading department data:', error);
        this.handleDepartmentNotFound();
      }
    });
  }

  private finishLoading(): void {
    this.isLoading.set(false);
    this.loaderService.hide();
  }

  private handleDepartmentNotFound(): void {
    this.finishLoading();
    this.notificationService.errorI18n(
      this.translate.instant('TOAST.ERROR'),
      this.translate.instant('DEPARTMENT_DETAILS.NOT_FOUND')
    );

    setTimeout(() => {
      this.router.navigate(['/departments']);
    }, 3000);
  }

  goBackToDepartments(): void {
    this.router.navigate(['/departments']).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  navigateToProfessor(professorSlug: string): void {
    this.router.navigate(['/professors', professorSlug]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }


  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`;
  }

  getCurrentLanguage(): string {
    return this.translate.currentLang || 'fr';
  }

  trackByProfessorId(index: number, professor: Professor): number {
    return professor.id;
  }
}
