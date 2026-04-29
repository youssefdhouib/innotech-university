import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '@environments/environment';
import { Application } from '@core/models/application';
import { Observable, map } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ApplicationService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  submitApplication(data: Application): Observable<{ code: number; message: string; data: Application }> {
    return this.http.post<{ code: number; message: string; data: Application }>(
      `${this.API}/formulaires/preinscription`,
      data
    );
}


  validatePreinscription(id: number): Observable<Application> {
    return this.http.post<{ code: number; message: string; data: Application }>(
      `${this.API}/preinscriptions/${id}/validate`,
      {}
    ).pipe(
      map(res => res.data)
    );
  }

  rejectPreinscription(id: number): Observable<Application> {
    return this.http.post<{ code: number; message: string; data: Application }>(
      `${this.API}/preinscriptions/${id}/reject`,
      {}
    ).pipe(
      map(res => res.data)
    );
  }
}
