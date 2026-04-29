import { Component, Input, Output, EventEmitter } from "@angular/core"
import { CommonModule } from "@angular/common"
import { TranslateModule } from "@ngx-translate/core"
import type { News } from "@core/models/news"
import { environment } from "@environments/environment"

@Component({
  selector: "app-news-card",
  standalone: true,
  imports: [CommonModule, TranslateModule],
  templateUrl: "./news-card.component.html",
  styleUrls: ["./news-card.component.css"],
})
export class NewsCardComponent {
  @Input() news!: News
  @Output() cardClick = new EventEmitter<News>()

  onCardClick(): void {
    this.cardClick.emit(this.news)
  }

  getCategoryBadgeClass(): string {
    switch (this.news.category) {
      case "notice":
        return "bg-gradient-to-r from-blue-500 to-blue-600 shadow-blue-500/25"
      case "announcement":
        return "bg-gradient-to-r from-green-500 to-green-600 shadow-green-500/25"
      case "event":
        return "bg-gradient-to-r from-purple-500 to-purple-600 shadow-purple-500/25"
      default:
        return "bg-gradient-to-r from-gray-500 to-gray-600 shadow-gray-500/25"
    }
  }

  getCategoryLabel(): string {
    return `NEWS.CATEGORIES.${this.news.category.toUpperCase()}`
  }

  getCategoryIcon(): string {
    switch (this.news.category) {
      case "notice":
        return "pi pi-info-circle"
      case "announcement":
        return "pi pi-megaphone"
      case "event":
        return "pi pi-calendar"
      default:
        return "pi pi-file"
    }
  }

  getDefaultImage(): string {
    return `/assets/images/news/default-${this.news.category}.jpg`
  }

  formatDate(dateString: string): string {
    const date = new Date(dateString)
    return date.toLocaleDateString("en-US", {
      month: "short",
      day: "numeric",
      year: "numeric",
    })
  }
  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`
  }
}
