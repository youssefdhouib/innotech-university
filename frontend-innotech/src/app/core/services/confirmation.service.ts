import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from '@environments/environment';
import { map, Observable } from 'rxjs';
import { Application } from '@core/models/application';
import { DocumentType } from '@core/models/document-type';

interface ConfirmationFormResponse {
  application: Application;
  required_documents: DocumentType[];
}

@Injectable({ providedIn: 'root' })
export class ConfirmationService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  /**
   * Get application recap and required documents
   */
  getConfirmationForm(applicationId: number, queryParams: string = ''): Observable<ConfirmationFormResponse> {
    const url = `${this.API}/formulaires/confirm-preinscription/${applicationId}${queryParams}`;
    return this.http.get<{ code: number; message: string; data: ConfirmationFormResponse }>(url)
      .pipe(map((res: { data: any; }) => res.data)); // <== YOU NEED THIS .pipe(map(...)) !!
  }
  


  /**
   * Submit confirmation documents
   */
  submitConfirmationForm(applicationId: number, formData: FormData): Observable<{ message: string }> {
    return this.http.post<{ message: string }>(
      `${this.API}/formulaires/confirm-preinscription/${applicationId}`,
      formData
    );
  }
}
