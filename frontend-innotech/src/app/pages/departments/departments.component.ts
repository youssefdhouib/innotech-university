import { Component, OnInit, OnDestroy, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { Subject, takeUntil } from 'rxjs';

import { LoaderService } from '@core/services/loader.service';
import { NotificationService } from '@core/services/notification.service';
import { DepartmentService } from '@core/services/department.service';
import { LoaderComponent } from '@shared/components/loader/loader.component';
import { Department } from '@core/models/department';
import { PageHeaderComponent } from '@shared/components/page-header/page-header.component';
import { environment } from '@environments/environment';

@Component({
  selector: 'app-departments',
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent, PageHeaderComponent],
  templateUrl: './departments.component.html',
  styleUrls: ['./departments.component.css']
})
export class DepartmentsComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>();

  // Using Angular 19 signals
  departments = signal<Department[]>([]);
  isLoading = signal<boolean>(true);

  constructor(
    private router: Router,
    private translate: TranslateService,
    private departmentService: DepartmentService,
    public loaderService: LoaderService,
    private notificationService: NotificationService
  ) {}

  ngOnInit(): void {
    this.loadDepartments();
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  private loadDepartments(): void {
    this.isLoading.set(true);
    this.loaderService.show();

    this.departmentService
      .getAllDepartments()
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (departments) => {
          this.departments.set(departments);
          this.finishLoading();
        },
        error: (error) => {
          console.error('Error loading departments:', error);
          this.finishLoading();
          this.notificationService.errorI18n(
            this.translate.instant('TOAST.ERROR'),
            this.translate.instant('DEPARTMENTS.LOAD_ERROR')
          );
        }
      });
  }

  private finishLoading(): void {
    this.isLoading.set(false);
    this.loaderService.hide();
  }

  navigateToDepartment(departmentId: number): void {
    this.router.navigate(['/departments', departmentId]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }



  getCurrentLanguage(): string {
    return this.translate.currentLang || 'fr';
  }

  trackByDepartmentId(index: number, department: Department): number {
    return department.id;
  }
  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`;
  }
}
