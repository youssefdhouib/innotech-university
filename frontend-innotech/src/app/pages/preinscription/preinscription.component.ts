import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ApplicationService } from '@core/services/application.service';
import { DegreeService } from '@core/services/degree.service';
import { Degree } from '@core/models/degree';
import { Gender } from '@core/models/types';
import { NotificationService } from '@core/services/notification.service';
import { Application } from '@core/models/application';
import { TranslateModule, TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-preinscription',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule,TranslateModule],
  templateUrl: './preinscription.component.html'
})
export class PreinscriptionComponent implements OnInit {
  licenceDegrees: Degree[] = [];
mastereDegrees: Degree[] = [];
  preinscriptionForm!: FormGroup;
  showSuccessModal = false;
  degrees: Degree[] = [];
  genders = [
    { label: 'MALE', value: 'male' },
    { label: 'FEMALE', value: 'female' },
    { label: 'OTHER', value: 'other' }
];

  submitting = false;
  successMessage = '';

  constructor(
    private fb: FormBuilder,
    private applicationService: ApplicationService,
    private degreeService: DegreeService,
    private notifier: NotificationService,
    private translate: TranslateService
  ) {}

  ngOnInit() {
    this.preinscriptionForm = this.fb.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      first_name_ar: ['',Validators.required],
      last_name_ar: ['',Validators.required],
      desired_degree_id: [null, Validators.required],
      cin: ['', [
        Validators.required,
        Validators.pattern(/^\d{8}$/)
      ]],
      passport: [''],
      birth_date: ['', Validators.required],
      country: ['', Validators.required],
      gender: ['', Validators.required],
      address: ['',Validators.required],
      phone: ['',Validators.required],
      previous_degree: ['',Validators.required],
      graduation_year: ['',Validators.required],
      how_did_you_hear: [''],
    });

    this.degreeService.getAllDegrees().subscribe({
      next: (res) => {
        this.degrees = res;
        this.licenceDegrees = this.degrees.filter(d => d.level === 'Licence');
        this.mastereDegrees = this.degrees.filter(d => d.level === 'Mastere');
    },
      error: () => this.notifier.error('Erreur lors du chargement des diplômes.')
    });
  }

  get f() {
    return this.preinscriptionForm.controls;
  }

  onSubmit() {
    if (this.preinscriptionForm.invalid) {
        this.preinscriptionForm.markAllAsTouched();
        console.log('Form is invalid, showing error toast...');
        this.notifier.error(this.translate.instant('VALIDATION.REQUIRED_FIELDS'));
        return;
    }

    const payload: Application = {
        ...this.preinscriptionForm.value,
        desired_degree_id: Number(this.preinscriptionForm.value.desired_degree_id)
    };

    this.submitting = true;
    this.successMessage = '';

    this.applicationService.submitApplication(payload).subscribe({
      next: (res:any) => {
        console.log('Response from backend:', res);
        this.successMessage = res.message ?? 'Préinscription enregistrée avec succès.';
        this.showSuccessModal = true;
        this.preinscriptionForm.reset();
        setTimeout(() => this.showSuccessModal = false, 4000);
        },
        error: (err) => {
            console.error('Full error object:', err);

             //  Toujours remettre submitting à false même en cas d'erreur
             this.submitting = false;

             //  Gestion des erreurs Laravel détaillées
             if (err?.error) {
                 // Si un message global est présent


                 // Si des erreurs de validation sont présentes
                 if (err.error.errors) {
                     const errors = err.error.errors;
                     for (const field in errors) {
                         if (errors.hasOwnProperty(field)) {
                             const fieldErrors = Array.isArray(errors[field]) ? errors[field] : [errors[field]];
                             fieldErrors.forEach((errorMessage: string) => {
                                 this.notifier.error(`${errorMessage}`);
                             });
                         }
                     }
                 }
             } else {
                 // Fallback générique
                 this.notifier.error(this.translate.instant('TOAST.ERROR'));
             }
         },
        complete: () => this.submitting = false
    });
}

}
