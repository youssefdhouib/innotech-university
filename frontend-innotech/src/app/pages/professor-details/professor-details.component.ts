import { Component, OnInit, OnDestroy, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { Subject, takeUntil } from 'rxjs';

import { LoaderService } from '../../core/services/loader.service';
import { NotificationService } from '../../core/services/notification.service';
import { ProfessorService } from '../../core/services/professor.service';
import { DepartmentService } from '../../core/services/department.service';
import { LoaderComponent } from '../../shared/components/loader/loader.component';
import { Professor } from '../../core/models/professor';
import { Department } from '../../core/models/department';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-professor-details',
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent],
  templateUrl: './professor-details.component.html',
  styleUrls: ['./professor-details.component.css']
})
export class ProfessorDetailsComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>();

  // Using Angular 19 signals for better reactivity
  professor = signal<Professor | null>(null);
  department = signal<Department | null>(null);
  isLoading = signal<boolean>(true);
  profileSlug = signal<string>('');

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private translate: TranslateService,
    private professorService: ProfessorService,
    private departmentService: DepartmentService,
    public loaderService: LoaderService,
    private notificationService: NotificationService
  ) {}

  ngOnInit(): void {
    this.route.params.pipe(takeUntil(this.destroy$)).subscribe((params) => {
      this.profileSlug.set(params['profileSlug']);
      if (this.profileSlug()) {
        this.loadProfessorData();
      }
    });
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  private loadProfessorData(): void {
    this.isLoading.set(true);
    this.loaderService.show();

    this.professorService
      .getProfessorBySlug(this.profileSlug())
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (professor) => {
          if (professor) {
            this.professor.set(professor);
            this.loadDepartmentData(professor.department_id);
          } else {
            this.handleProfessorNotFound();
          }
        },
        error: (error) => {
          console.error('Error loading professor:', error);
          this.handleProfessorNotFound();
        }
      });
  }

  private loadDepartmentData(departmentId: number): void {
    if (this.professor()?.department) {
      this.department.set(this.professor()!.department as Department);
      this.finishLoading();
      return;
    }

    this.departmentService
      .getDepartmentById(departmentId)
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (department) => {
          this.department.set(department);
          this.finishLoading();
         /*  this.notificationService.successI18n(
            this.translate.instant('TOAST.SUCCESS'),
            this.translate.instant('PROFESSOR_DETAILS.DATA_LOADED')
          ); */
        },
        error: (error) => {
          console.error('Error loading department:', error);
          this.finishLoading();
          this.notificationService.errorI18n(
            this.translate.instant('TOAST.ERROR'),
            this.translate.instant('PROFESSOR_DETAILS.LOAD_ERROR')
          );
        }
      });
  }

  private finishLoading(): void {
    this.isLoading.set(false);
    this.loaderService.hide();
  }

  private handleProfessorNotFound(): void {
    this.finishLoading();
    this.notificationService.errorI18n(
      this.translate.instant('TOAST.ERROR'),
      this.translate.instant('PROFESSOR_DETAILS.NOT_FOUND')
    );

    setTimeout(() => {
      this.router.navigate(['/professors']);
    }, 3000);
  }

  downloadCV(): void {
    const prof = this.professor();
    if (prof?.cv_attached_file) {
      const link = document.createElement('a');
      link.href = this.getFileUrl(prof.cv_attached_file);
      link.download = `${prof.first_name}-${prof.last_name}-CV.pdf`;
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      this.notificationService.successI18n(
        this.translate.instant('TOAST.SUCCESS'),
        this.translate.instant('PROFESSOR_DETAILS.CV_DOWNLOAD_SUCCESS')
      );
    } else {
      this.notificationService.errorI18n(
        this.translate.instant('TOAST.ERROR'),
        this.translate.instant('PROFESSOR_DETAILS.CV_NOT_AVAILABLE')
      );
    }
  }

  sendEmail(): void {
    const prof = this.professor();
    if (prof?.email) {
      const subject = encodeURIComponent('Contact from InnoTech University Website');
      const body = encodeURIComponent(`Dear ${prof.first_name} ${prof.last_name},\n\n`);
      window.open(`mailto:${prof.email}?subject=${subject}&body=${body}`);
    }
  }

  goBack(): void {
    this.router.navigate(['/professors']);
  }

  getCurrentLanguage(): string {
    return this.translate.currentLang || 'en';
  }

  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`;
  }

  getFileUrl(filePath: string): string {
    return `${environment.StorageUrl}/${filePath}`;
  }
}
