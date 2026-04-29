import { Injectable } from '@angular/core';
import { MessageService } from 'primeng/api';

@Injectable({ providedIn: 'root' })
export class NotificationService {
  constructor(private messageService: MessageService) {}

  private show(type: 'success' | 'error' | 'warn' | 'info', summary: string, detail?: string) {
    this.messageService.add({
      severity: type,
      summary,
      detail,
      life: 3000
    });
  }

  success(msg: string) {
    this.show('success', 'Succès', msg);
  }

  error(msg: string) {
    this.show('error', 'Erreur', msg);
  }
    // Internationalized versions
    successI18n(summary: string, detail?: string) {
      this.show("success", summary, detail)
    }

    errorI18n(summary: string, detail?: string) {
      this.show("error", summary, detail)
    }

    warnI18n(summary: string, detail?: string) {
      this.show("warn", summary, detail)
    }

    infoI18n(summary: string, detail?: string) {
      this.show("info", summary, detail)
    }
}
