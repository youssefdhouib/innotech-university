import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Router } from '@angular/router';
import { TranslateService, TranslateModule } from '@ngx-translate/core';
import { DropdownModule } from 'primeng/dropdown';
import { FormsModule } from '@angular/forms';
import { NotificationService } from "@core/services/notification.service"
import { setLanguage } from '@core/state/language.state';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [CommonModule, RouterModule, DropdownModule, TranslateModule, FormsModule],
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  isMobileMenuOpen = false;
  currentLanguage = 'fr';
  isMobileDropdownOpen = false;

  selectedLanguage!: { label: string; value: string; icon: string };
  languages = [
    { label: 'English', value: 'en', icon: '🇺🇸' },
    { label: 'Français', value: 'fr', icon: '🇫🇷' },
    { label: 'العربية', value: 'ar', icon: 'Ar' }
  ];


  navigationItems = [
    { label: 'NAV.HOME', route: '/home', icon: 'pi pi-home' },
   /*  { label: 'NAV.ABOUT', route: '/about', icon: 'pi pi-info-circle' }, */
    { label: 'NAV.DEGREES', route: '/degrees', icon: 'pi pi-book' },
    { label: 'NAV.CONTACT', route: '/contact', icon: 'pi pi-envelope' }
  ];

  constructor(
    private translate: TranslateService,
    private notificationService: NotificationService,
    private router: Router
  ) { }

  ngOnInit() {
    this.currentLanguage = this.translate.currentLang || 'fr';
    this.selectedLanguage = this.languages.find(l => l.value === this.currentLanguage)!;
  }

  changeLang(event: any) {
    const lang = event.value;

    setLanguage(lang); // ✅ updates localStorage + the global BehaviorSubject

    this.currentLanguage = lang;
    this.selectedLanguage = this.languages.find(l => l.value === lang)!;

    if (lang === 'ar') {
      document.documentElement.setAttribute('dir', 'rtl');
      document.documentElement.setAttribute('lang', 'ar');
    } else {
      document.documentElement.setAttribute('dir', 'ltr');
      document.documentElement.setAttribute('lang', lang);
    }

    this.translate.use(lang); // ✅ still required for ngx-translate
  }



  toggleMobileMenu() {
    this.isMobileMenuOpen = !this.isMobileMenuOpen;
  }

  closeMobileMenu() {
    this.isMobileMenuOpen = false;
  }

  navigateToExtranet() {
    this.notificationService.infoI18n(
      this.translate.instant("NAV.NAVIGATION"),
      this.translate.instant("NAV.EXTRANET_COMING_SOON")
    );
    this.closeMobileMenu();
  }


  navigateToRoute(route: string) {
    this.router.navigate([route]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
    this.closeMobileMenu();
  }
}
