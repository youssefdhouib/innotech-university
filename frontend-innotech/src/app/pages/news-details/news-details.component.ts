import { Component,    OnInit,  OnDestroy, signal, computed } from "@angular/core"
import { CommonModule, Location } from "@angular/common"
import { ActivatedRoute, Router } from "@angular/router"
import { TranslateModule,    TranslateService } from "@ngx-translate/core"
import { Subject, takeUntil, switchMap } from "rxjs"

import   { LoaderService } from "@core/services/loader.service"
import   { NotificationService } from "@core/services/notification.service"
import   { NewsService } from "@core/services/news.service"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { NewsCardComponent } from "@shared/components/news-card/news-card.component"
import   { News } from "@core/models/news"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"
import { environment } from "@environments/environment"

@Component({
  selector: "app-news-details",
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent, NewsCardComponent],
  templateUrl: "./news-details.component.html",
  styleUrls: ["./news-details.component.css"],
})
export class NewsDetailsComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  // Using Angular 19 signals
  isLoading = signal<boolean>(true)
  news = signal<News | null>(null)
  allNews = signal<News[]>([])

  // Computed signals
  relatedNews = computed(() => {
    const currentNews = this.news()
    if (!currentNews) return []

    return this.allNews()
      .filter((item) => item.id !== currentNews.id && item.category === currentNews.category && item.is_published)
      .slice(0, 3)
  })

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private location: Location,
    private translate: TranslateService,
    private newsService: NewsService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
  ) {}

  ngOnInit(): void {
    this.route.params
      .pipe(
        takeUntil(this.destroy$),
        switchMap((params) => {
          const id = +params["id"]
          this.loadNews(id)
          return this.newsService.getAllNews({ published: true })
        }),
      )
      .subscribe({
        next: (allNews) => {
          this.allNews.set(allNews)
        },
        error: (error) => {
          console.error("Error loading related news:", error)
        },
      })
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  private loadNews(id: number): void {
    this.isLoading.set(true)
    this.loaderService.show()

    this.newsService
      .getNewsById(id)
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (news) => {
          this.news.set(news)
          this.finishLoading()

          // Update page title
          document.title = `${news.title} - InnoTech University`
        },
        error: (error) => {
          console.error("Error loading news:", error)
          this.finishLoading()
          this.notificationService.errorI18n(
            this.translate.instant("TOAST.ERROR"),
            this.translate.instant("NEWS.LOAD_ERROR"),
          )
        },
      })
  }

  private finishLoading(): void {
    this.isLoading.set(false)
    this.loaderService.hide()
  }

  goBack(): void {
    this.location.back()
  }

  navigateToNews(news: News): void {
    this.router.navigate(["/news", news.id]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  getCategoryLabel(category: string): string {
    return `NEWS.CATEGORIES.${category.toUpperCase()}`
  }

  getCategoryBadgeClass(category: string): string {
    switch (category) {
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

  getCategoryPrimeIcon(category: string): string {
    switch (category) {
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

  getDefaultImage(category: string): string {
    return `/assets/images/news/default-${category}.jpg`
  }

  formatDate(dateString: string): string {
    const date = new Date(dateString)
    return date.toLocaleDateString("en-US", {
      month: "long",
      day: "numeric",
      year: "numeric",
    })
  }

  getFormattedContent(): string {
    const content = this.news()?.description || ""
    // Convert line breaks to HTML paragraphs
    return content
      .split("\n")
      .map((paragraph) => (paragraph.trim() ? `<p class="mb-6">${paragraph}</p>` : ""))
      .join("")
  }

  shareOnSocial(platform: string): void {
    const news = this.news()
    if (!news) return

    const url = window.location.href
    const title = news.title
    const description = news.description

    let shareUrl = ""

    switch (platform) {
      case "facebook":
        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
        break
      case "twitter":
        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`
        break
      case "linkedin":
        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`
        break
    }

    if (shareUrl) {
      window.open(shareUrl, "_blank", "width=600,height=400")
    }
  }

  copyLink(): void {
    const url = window.location.href
    navigator.clipboard
      .writeText(url)
      .then(() => {
        this.notificationService.successI18n(
          this.translate.instant("TOAST.SUCCESS"),
          this.translate.instant("NEWS.LINK_COPIED"),
        )
      })
      .catch(() => {
        this.notificationService.errorI18n(
          this.translate.instant("TOAST.ERROR"),
          this.translate.instant("NEWS.LINK_COPY_ERROR"),
        )
      })
  }

  getCurrentLanguage(): string {
    return this.translate.currentLang || "fr"
  }
  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`
  }
}
