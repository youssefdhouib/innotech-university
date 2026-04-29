import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '@environments/environment';
import { Observable } from 'rxjs';
import { Document } from '@core/models/document';
import { DocumentType } from '@core/models/document-type'; 

@Injectable({ providedIn: 'root' })
export class DocumentService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  listAllDocuments(): Observable<Document[]> {
    return this.http.get<Document[]>(`${this.API}/documents`);
  }

  getDocumentById(id: number): Observable<Document> {
    return this.http.get<Document>(`${this.API}/documents/${id}`);
  }

  listDocumentsByApplication(appId: number): Observable<Document[]> {
    return this.http.get<Document[]>(`${this.API}/applications/${appId}/documents`);
  }

  listDocumentTypes(): Observable<DocumentType[]> {
    return this.http.get<DocumentType[]>(`${this.API}/documents/types`);
  }

  uploadDocument(formData: FormData): Observable<Document> {
    return this.http.post<Document>(`${this.API}/documents`, formData);
  }

  updateDocument(id: number, data: Partial<Document>): Observable<Document> {
    return this.http.put<Document>(`${this.API}/documents/${id}`, data);
  }

  deleteDocument(id: number): Observable<null> {
    return this.http.delete<null>(`${this.API}/documents/${id}`);
  }
}
