import { HttpClient, HttpParams } from "@angular/common/http"
import { Injectable } from "@angular/core"
import { environment } from "@environments/environment"
import {  Observable, map } from "rxjs"
import  { News, NewsFilter } from "@core/models/news"

@Injectable({ providedIn: "root" })
export class NewsService {
  private readonly API = environment.apiUrl

  constructor(private http: HttpClient) {}

  getAllNews(filter?: NewsFilter): Observable<News[]> {
    let params = new HttpParams()

    if (filter?.category) {
      params = params.set("category", filter.category)
    }
    if (filter?.search) {
      params = params.set("search", filter.search)
    }
    if (filter?.published !== undefined) {
      params = params.set("published", filter.published.toString())
    }

    return this.http
      .get<{ code: number; message: string; data: News[] }>(`${this.API}/news`, { params })
      .pipe(map((res) => res.data))
  }

  getNewsById(id: number): Observable<News> {
    return this.http
      .get<{ code: number; message: string; data: News }>(`${this.API}/news/${id}`)
      .pipe(map((res) => res.data))
  }

  getNewsByCategory(category: string, limit?: number): Observable<News[]> {
    let params = new HttpParams().set("category", category)
    if (limit) {
      params = params.set("limit", limit.toString())
    }

    return this.http
      .get<{ code: number; message: string; data: News[] }>(`${this.API}/news`, { params })
      .pipe(map((res) => res.data))
  }

  getLatestNews(limit = 6): Observable<News[]> {
    const params = new HttpParams()
      .set("is_published", "true")
      .set("limit", limit.toString())
      .set("sort", "created_at")
      .set("order", "desc")

    return this.http
      .get<{ code: number; message: string; data: News[] }>(`${this.API}/news`, { params })
      .pipe(map((res) => res.data))
  }

  createNews(data: Partial<News>): Observable<News> {
    return this.http
      .post<{ code: number; message: string; data: News }>(`${this.API}/news`, data)
      .pipe(map((res) => res.data))
  }

  updateNews(id: number, data: Partial<News>): Observable<News> {
    return this.http
      .put<{ code: number; message: string; data: News }>(`${this.API}/news/${id}`, data)
      .pipe(map((res) => res.data))
  }

  deleteNews(id: number): Observable<null> {
    return this.http
      .delete<{ code: number; message: string; data: null }>(`${this.API}/news/${id}`)
      .pipe(map((res) => res.data))
  }
}
