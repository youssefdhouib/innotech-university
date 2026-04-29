import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '@environments/environment';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ContactService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  submitContactForm(data: any): Observable<{ message: string }> {
    return this.http.post<{ message: string }>(`${this.API}/formulaires/contact`, data);
  }
}
