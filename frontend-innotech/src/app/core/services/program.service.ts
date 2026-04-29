import { HttpClient } from "@angular/common/http"
import { Injectable } from "@angular/core"
import { environment } from "@environments/environment"
import { Program } from "@core/models/program"
import { Observable, map } from "rxjs"

@Injectable({ providedIn: "root" })
export class ProgramService {
  private readonly API = environment.apiUrl

  constructor(private http: HttpClient) {}

  getAllPrograms(): Observable<Program[]> {
    return this.http
      .get<{ code: number; message: string; data: Program[] }>(`${this.API}/programs`)
      .pipe(map((res) => res.data))
  }

  getProgramById(id: number): Observable<Program> {
    return this.http
      .get<{ code: number; message: string; data: Program }>(`${this.API}/programs/${id}`)
      .pipe(map((res) => res.data))
  }

  // New method to get programs by degree ID
  getProgramsByDegreeId(degreeId: number): Observable<Program[]> {
    return this.http
      .get<{ code: number; message: string; data: Program[] }>(`${this.API}/programs/degree/${degreeId}`)
      .pipe(map((res) => res.data))
  }

  createProgram(data: Partial<Program>): Observable<Program> {
    return this.http
      .post<{ code: number; message: string; data: Program }>(`${this.API}/programs`, data)
      .pipe(map((res) => res.data))
  }

  updateProgram(id: number, data: Partial<Program>): Observable<Program> {
    return this.http
      .put<{ code: number; message: string; data: Program }>(`${this.API}/programs/${id}`, data)
      .pipe(map((res) => res.data))
  }

  deleteProgram(id: number): Observable<null> {
    return this.http
      .delete<{ code: number; message: string; data: null }>(`${this.API}/programs/${id}`)
      .pipe(map((res) => res.data))
  }
}
