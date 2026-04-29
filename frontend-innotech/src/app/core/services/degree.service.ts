import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '@environments/environment';
import { Degree } from '@core/models/degree';
import { map, Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class DegreeService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getAllDegrees(): Observable<Degree[]> {
    return this.http.get<{ code: number; message: string; data: Degree[] }>(`${this.API}/degrees`)
      .pipe(
        map(res => res.data)
      );
  }

  getDegreeById(id: number): Observable<Degree> {
    return this.http.get<{ code: number; message: string; data: Degree }>(`${this.API}/degrees/${id}`)
      .pipe(
        map(res => res.data)
      );
  }

  getDegreesByLevel(level: string): Observable<Degree[]> {
    return this.http.get<{ code: number; message: string; data: Degree[] }>(`${this.API}/degrees?level=${level}`)
      .pipe(
        map(res => res.data)
      );
  }

  createDegree(data: Partial<Degree>): Observable<Degree> {
    return this.http.post<{ code: number; message: string; data: Degree }>(`${this.API}/degrees`, data)
      .pipe(
        map(res => res.data)
      );
  }

  updateDegree(id: number, data: Partial<Degree>): Observable<Degree> {
    return this.http.put<{ code: number; message: string; data: Degree }>(`${this.API}/degrees/${id}`, data)
      .pipe(
        map(res => res.data)
      );
  }

  deleteDegree(id: number): Observable<null> {
    return this.http.delete<{ code: number; message: string; data: null }>(`${this.API}/degrees/${id}`)
      .pipe(
        map(res => res.data)
      );
  }
}
