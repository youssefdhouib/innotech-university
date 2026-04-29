// src/app/shared/components/loader.component.ts

import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LoaderService } from '@core/services/loader.service';

@Component({
  selector: 'app-loader',
  standalone: true,
  imports: [CommonModule],
  template: `
    <div *ngIf="loader.loading()" class="fixed inset-0 bg-white bg-opacity-40 flex items-center justify-center z-50">
      <div class="loader border-4 border-t-[var(--InnoTech-primary)]"></div>
    </div>
  `,
  styles: [`
    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid var(--InnoTech-primary);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  `]
})
export class LoaderComponent {
  constructor(public loader: LoaderService) {}
}
