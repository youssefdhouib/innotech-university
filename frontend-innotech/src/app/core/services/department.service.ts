import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '@environments/environment';
import { Observable, map } from 'rxjs';
import { Department } from '@core/models/department';

@Injectable({ providedIn: 'root' })
export class DepartmentService {
  private readonly API = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getAllDepartments(): Observable<Department[]> {
    return this.http.get<{ code: number; message: string; data: Department[] }>(`${this.API}/departments`)
      .pipe(map(res => res.data));
  }

  getDepartmentById(id: number): Observable<Department> {
    return this.http.get<{ code: number; message: string; data: Department }>(`${this.API}/departments/${id}`)
      .pipe(map(res => res.data));
  }

  createDepartment(data: Partial<Department>): Observable<Department> {
    return this.http.post<{ code: number; message: string; data: Department }>(`${this.API}/departments`, data)
      .pipe(map(res => res.data));
  }

  updateDepartment(id: number, data: Partial<Department>): Observable<Department> {
    return this.http.put<{ code: number; message: string; data: Department }>(`${this.API}/departments/${id}`, data)
      .pipe(map(res => res.data));
  }

  deleteDepartment(id: number): Observable<null> {
    return this.http.delete<{ code: number; message: string; data: null }>(`${this.API}/departments/${id}`)
      .pipe(map(res => res.data));
  }
}
