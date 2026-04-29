import { Injectable } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

@Injectable({ providedIn: 'root' })
export class I18nService {
  defaultLang = 'fr';

  constructor(private translate: TranslateService) {
    const lang = localStorage.getItem('lang') || this.defaultLang;
    this.translate.addLangs(['en', 'fr', 'ar']);
    this.translate.setDefaultLang(this.defaultLang);
    this.translate.use(lang);
  }

  useLanguage(lang: string) {
    localStorage.setItem('lang', lang);
    this.translate.use(lang);
  }

  get currentLang() {
    return this.translate.currentLang || this.defaultLang;
  }
}

