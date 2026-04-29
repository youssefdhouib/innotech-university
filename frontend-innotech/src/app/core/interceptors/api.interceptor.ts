import { Injectable } from '@angular/core';
import {
  HttpEvent, HttpInterceptor, HttpHandler, HttpRequest, HttpErrorResponse
} from '@angular/common/http';
import { Observable, catchError, finalize, throwError } from 'rxjs';
import { LoaderService } from '../services/loader.service';
import { NotificationService } from '../services/notification.service';
import { language$ } from '../state/language.state';

@Injectable()
export class ApiInterceptor implements HttpInterceptor {
  constructor(
    private loader: LoaderService,
    private notifier: NotificationService
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    this.loader.show();

    const lang = language$.getValue(); // ✅ get current value from subject
      // List of excluded URLs (can be partial matches or regex)
  const excludedUrls = [
    '/api/chatbot', // 👈 Add more if needed
  ];

  const isExcluded = excludedUrls.some(url => req.url.includes(url));
  if (isExcluded) {
    this.loader.hide();
  }
  if (!isExcluded) {
    this.loader.show();
  }
    const modifiedReq = req.clone({
      headers: req.headers.set('Accept-Language', lang)
    });

    return next.handle(modifiedReq).pipe(
      catchError((error: HttpErrorResponse) => {
        const message = error.error?.message || error.message || 'Une erreur est survenue';
        this.notifier.error(message);
        return throwError(() => error);
      }),
      finalize(() => this.loader.hide())
    );
  }
}
