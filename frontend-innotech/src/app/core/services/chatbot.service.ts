// src/app/core/services/chatbot.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '@environments/environment';

@Injectable({ providedIn: 'root' })
export class ChatbotService {
    private apiUrl = `${environment.apiUrl}/chatbot`;

  constructor(private http: HttpClient) {}

  sendMessage(message: string): Observable<{ data: { reply: string } }> {
    console.log('Sending POST to chatbot:', message);
    return this.http.post<{ data: { reply: string } }>(this.apiUrl, { message });
  }
}
