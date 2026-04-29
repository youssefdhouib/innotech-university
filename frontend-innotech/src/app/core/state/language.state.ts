import { BehaviorSubject } from 'rxjs';

const defaultLang = localStorage.getItem('lang') || 'fr';

export const language$ = new BehaviorSubject<string>(defaultLang);

// Optional helper
export function setLanguage(lang: string) {
  localStorage.setItem('lang', lang);
  language$.next(lang);
}
