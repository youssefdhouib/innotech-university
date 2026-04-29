import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ConfirmationService } from '@core/services/confirmation.service';
import { Application } from '@core/models/application';
import { DocumentType } from '@core/models/document-type';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NotificationService } from '@core/services/notification.service';
import { DegreeService } from '@core/services/degree.service';

type ApplicationKey = keyof Application;

@Component({
  selector: 'app-confirmation',
  templateUrl: './confirmation.component.html',
  imports: [CommonModule, ReactiveFormsModule, TranslateModule, FormsModule]
})
export class ConfirmationComponent implements OnInit {
  application: Application | null = null;

  showSuccessModal = false;
  requiredDocuments: DocumentType[] = [];
  recapFields: { key: ApplicationKey; label: string }[] = [
    { key: 'first_name', label: 'FORM.FIRST_NAME' },
    { key: 'last_name', label: 'FORM.LAST_NAME' },
    { key: 'first_name_ar', label: 'FORM.FIRST_NAME_AR' },
    { key: 'last_name_ar', label: 'FORM.LAST_NAME_AR' },
    { key: 'email', label: 'FORM.EMAIL' },
    { key: 'cin', label: 'FORM.CIN' },
    { key: 'passport', label: 'FORM.PASSPORT' },
    { key: 'birth_date', label: 'FORM.BIRTH_DATE' },
    { key: 'country', label: 'FORM.COUNTRY' },
    { key: 'gender', label: 'FORM.GENDER' },
    { key: 'address', label: 'FORM.ADDRESS' },
    { key: 'phone', label: 'FORM.PHONE' },
    { key: 'previous_degree', label: 'FORM.PREVIOUS_DEGREE' },
    { key: 'graduation_year', label: 'FORM.GRADUATION_YEAR' },
    { key: 'how_did_you_hear', label: 'FORM.HOW_DID_YOU_HEAR' },
    { key: 'desired_degree_id', label: 'FORM.DESIRED_DEGREE' }
];

  documentNameMap: { [key: string]: string } = {
    "Copie conforme du diplôme du baccalauréat": "DOCS.BAC_COPY",
    "Certificat de naissance": "DOCS.BIRTH_CERTIFICATE",
    "Photo d’identité": "DOCS.ID_PHOTO",
    "Copie de la carte d’identité nationale (CIN) ou passeport": "DOCS.ID_COPY",
    "Exemplaire du règlement intérieur signé": "DOCS.SIGNED_RULES",
    "Copie légalisée du diplôme de Licence ou équivalent": "DOCS.LICENSE_DIPLOMA",
    "Relevés de notes (copies conformes)": "DOCS.TRANSCRIPTS"
  };
  
  submitting = false;
  successMessage = '';
  fileErrors: { [key: number]: string } = {};
  files: { [key: number]: File } = {};
  showErrorModal = false;
  errorMessage = '';
  degreeNameCache: { [id: number]: string } = {}; // cache to avoid repeated calls
  constructor(
    private route: ActivatedRoute,
    private confirmationService: ConfirmationService,
    private notifier: NotificationService,
    private translate: TranslateService,
    public router: Router,
    private degreeService: DegreeService
  ) { }

  ngOnInit() {
    const appId = Number(this.route.snapshot.paramMap.get('id'));

    // Use window.location.search to get the EXACT original query string
    // without any re-encoding that would break the HMAC signature
    const queryParams = window.location.search;

    this.confirmationService.getConfirmationForm(appId, queryParams).subscribe({
      next: (data) => {
        this.application = data.application;
        this.requiredDocuments = data.required_documents;
      },
      error: (err) => {
        console.error('API Error:', err);
        this.errorMessage = err.error?.message || 'Erreur lors du chargement du formulaire.';
        this.showErrorModal = true;
      }
    });
  }
 

  getDegreeNameById(id: number): void {
    if (!id || this.degreeNameCache[id]) return;

    this.degreeService.getDegreeById(id).subscribe({
      next: (degree) => { 
        this.degreeNameCache[id] = `${degree.name} (${degree.level})`;
      },
      error: () => {
        this.degreeNameCache[id] = '-';
      }
    });
  }
  getFieldValue(key: ApplicationKey): string | number {
    if (key === 'desired_degree_id') {
      this.getDegreeNameById(this.application?.desired_degree_id ?? 0);
      return this.degreeNameCache[this.application?.desired_degree_id ?? 0] ?? '-';
    }
    return this.application ? this.application[key] ?? '-' : '-';
  }

  onFileChange(event: any, docId: number) {
    const file: File = event.target.files[0];
    if (file) {
      if (!['application/pdf', 'image/jpeg', 'image/png'].includes(file.type)) {
        this.fileErrors[docId] = 'Format invalide. PDF, JPG, JPEG, PNG uniquement.';
        this.files[docId] = undefined as any;
        return;
      }
      if (file.size > 2 * 1024 * 1024) {
        this.fileErrors[docId] = 'Fichier trop volumineux (max 2MB).';
        this.files[docId] = undefined as any;
        return;
      }
      this.fileErrors[docId] = '';
      this.files[docId] = file;
    }
  }

  onSubmit() {
    console.log("Form submitted");
    this.submitting = true;
    const appId = Number(this.route.snapshot.paramMap.get('id'));
    const formData = new FormData();

    let missingFile = false;
    for (const doc of this.requiredDocuments) {
      if (this.files[doc.id]) {
        formData.append(`documents[${doc.id}]`, this.files[doc.id]);
      } else {
        this.fileErrors[doc.id] = 'Veuillez joindre ce fichier requis.';
        missingFile = true;
      }
    }

    if (missingFile) {
      this.notifier.error(this.translate.instant('TOAST.FILL_REQUIRED'));
      this.submitting = false;
      return;
    }

    this.confirmationService.submitConfirmationForm(appId, formData).subscribe({
      next: (res: any) => {
        console.log('Response from backend:', res);
        this.successMessage = res.message ?? 'Documents soumis avec succès.';
        this.showSuccessModal = true;

        // Optionally reset files
        this.files = {};
        this.fileErrors = {};
        
        setTimeout(() => {
          this.showSuccessModal = false;
          this.router.navigate(['/']);
        }, 5000);
      },
      error: (err) => {
        console.error('Full error object:', err);

        // Toujours remettre submitting à false même en cas d'erreur
        this.submitting = false;

        // Gestion des erreurs Laravel détaillées
        if (err?.error) {
         
          // Si des erreurs de validation sont présentes
          if (err.error.errors) {
            const errors = err.error.errors;
            for (const field in errors) {
              if (errors.hasOwnProperty(field)) {
                const fieldErrors = errors[field];
                fieldErrors.forEach((errorMessage: string) => {
                  this.notifier.error(`${field}: ${errorMessage}`);
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
