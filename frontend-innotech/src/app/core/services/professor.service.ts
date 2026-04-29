import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '@environments/environment';
import { Observable, map } from 'rxjs';
import { Professor } from '@core/models/professor';

@Injectable({ providedIn: 'root' })
export class ProfessorService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getAllProfessors(): Observable<Professor[]> {
    return this.http.get<{ code: number; message: string; data: Professor[] }>(`${this.API}/professors`)
      .pipe(map(res => res.data));
  }

  getProfessorById(id: number): Observable<Professor> {
    return this.http.get<{ code: number; message: string; data: Professor }>(`${this.API}/professors/${id}`)
      .pipe(map(res => res.data));
  }

  /**
   *  Get professors by department ID
   */
  getProfessorsByDepartment(departmentId: number): Observable<Professor[]> {
    return this.http.get<{ code: number; message: string; data: Professor[] }>(
      `${this.API}/departments/${departmentId}/professors`
    ).pipe(
      map(res => res.data)
    );
  }
  getProfessorBySlug(slug: string): Observable<Professor> {
    return this.http.get<{ code: number; message: string; data: Professor }>(
      `${this.API}/professors/slug/${slug}`
    ).pipe(
      map(res => res.data)
    );
  }


  createProfessor(data: Partial<Professor>): Observable<Professor> {
    return this.http.post<{ code: number; message: string; data: Professor }>(`${this.API}/professors`, data)
      .pipe(map(res => res.data));
  }

  updateProfessor(id: number, data: Partial<Professor>): Observable<Professor> {
    return this.http.put<{ code: number; message: string; data: Professor }>(`${this.API}/professors/${id}`, data)
      .pipe(map(res => res.data));
  }

  deleteProfessor(id: number): Observable<null> {
    return this.http.delete<{ code: number; message: string; data: null }>(`${this.API}/professors/${id}`)
      .pipe(map(res => res.data));
  }
}
