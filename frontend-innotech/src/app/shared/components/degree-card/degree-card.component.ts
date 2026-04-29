import { Component, Input, Output, EventEmitter } from "@angular/core"
import { CommonModule } from "@angular/common"
import { TranslateModule } from "@ngx-translate/core"
import { Router } from "@angular/router"
import { Degree } from "@core/models/degree"
import { I18nService } from "@core/i18n/i18n.service"
import { environment } from "@environments/environment"

@Component({
  selector: "app-degree-card",
  standalone: true,
  imports: [CommonModule, TranslateModule],
  templateUrl: "./degree-card.component.html",
  styleUrls: ["./degree-card.component.css"],
})
export class DegreeCardComponent {
  @Input() degree!: Degree
  @Output() cardClick = new EventEmitter<Degree>()

  constructor(
    private i18nService: I18nService,
    private router: Router,
  ) {}

  ngOnInit(): void {
    console.log(this.degree);
  }

  getBackgroundImage(cover_image: string): string {

    return `${environment.StorageUrl}/${cover_image}`;
  }

  onCardClick(): void {
    // Emit the event for parent component
    this.cardClick.emit(this.degree)

    // Also handle direct navigation (optional - you can choose one approach)
    // this.router.navigate(['/degrees', this.degree.id]);
  }

  getCurrentLanguage(): string {
    return this.i18nService.currentLang
  }
}
