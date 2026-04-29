import { Component, inject } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { ToastModule } from 'primeng/toast';
import { ButtonModule } from 'primeng/button';
import { HeaderComponent } from '@shared/components/header/header.component';
import { FooterComponent } from '@shared/components/footer/footer.component';
import { language$ } from '@core/state/language.state';
import { ChatbotComponent } from '@shared/components/chatbot/chatbot.component';
import { skip } from 'rxjs';

@Component({
  selector: 'app-root',
  imports: [
    ToastModule,
    RouterOutlet,
    HeaderComponent,
    FooterComponent,
    ChatbotComponent
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend-InnoTech';
  private router = inject(Router);

  ngOnInit(): void {
    language$.pipe(skip(1)).subscribe(() => {
      // Trigger re-navigation to the current route to re-fetch all data
      // skip(1) ensures this only fires on actual language changes, not the initial emit
      const currentUrl = this.router.url;
      this.router.navigateByUrl('/', { skipLocationChange: true }).then(() => {
        this.router.navigateByUrl(currentUrl);
      });
    });
  }
}
