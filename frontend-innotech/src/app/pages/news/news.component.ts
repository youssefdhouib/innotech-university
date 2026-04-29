import { Component,    OnInit,   OnDestroy, signal, computed } from "@angular/core"
import { CommonModule } from "@angular/common"
import { ActivatedRoute, Router } from "@angular/router"
import { TranslateModule,    TranslateService } from "@ngx-translate/core"
import { Subject, takeUntil } from "rxjs"

import   { LoaderService } from "@core/services/loader.service"
import   { NotificationService } from "@core/services/notification.service"
import   { NewsService } from "@core/services/news.service"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { NewsCardComponent } from "@shared/components/news-card/news-card.component"
import { NewsFilterComponent } from "@shared/components/news-filter/news-filter.component"
import   { News, NewsFilter } from "@core/models/news"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"
import { environment } from "@environments/environment"

@Component({
  selector: "app-news",
  standalone: true,
  imports: [
    CommonModule,
    TranslateModule,
    LoaderComponent,
    NewsCardComponent,
    NewsFilterComponent,
    PageHeaderComponent,
  ],
  templateUrl: "./news.component.html",
  styleUrls: ["./news.component.css"],
})
export class NewsComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  // Using Angular 19 signals
  isLoading = signal<boolean>(true)
  allNews = signal<News[]>([])
  currentFilter = signal<NewsFilter>({})

  // Computed signals
  featuredNews = computed(() => {
    const publishedNews = this.allNews().filter((news) => news.is_published)
    return publishedNews.slice(0, 3)
  })

  filteredNews = computed(() => {
    const filter = this.currentFilter()
    let news = this.allNews().filter((item) => item.is_published)

    if (filter.category) {
      news = news.filter((item) => item.category === filter.category)
    }

    if (filter.search) {
      const searchTerm = filter.search.toLowerCase()
      news = news.filter(
        (item) => item.title.toLowerCase().includes(searchTerm) || item.description.toLowerCase().includes(searchTerm),
      )
    }

    return news
  })

  categoryCounts = computed(() => {
    const counts: { [key: string]: number } = {}
    const publishedNews = this.allNews().filter((news) => news.is_published)

    publishedNews.forEach((news) => {
      counts[news.category] = (counts[news.category] || 0) + 1
    })

    return counts
  })

  constructor(
    private router: Router,
    private translate: TranslateService,
    private newsService: NewsService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
    private route: ActivatedRoute,
  ) {}

  ngOnInit(): void {
    this.route.queryParams.subscribe((params) => {
      const category = params['category'];
      if (category) {
        this.currentFilter.set({ category, published: true });
      }
    });
    this.loadNews()

  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  private loadNews(): void {
    this.isLoading.set(true)
    this.loaderService.show()

    this.newsService
      .getAllNews({ published: true })
      .pipe(takeUntil(this.destroy$))
      .subscribe({
        next: (news) => {
          console.log(news);
          // Sort by created_at descending
          const sortedNews = news.sort(
            (a, b) => new Date(b.created_at || "").getTime() - new Date(a.created_at || "").getTime(),
          )
          this.allNews.set(sortedNews)
          this.finishLoading()
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

  onFilterChange(filter: NewsFilter): void {
    this.currentFilter.set(filter)
  }

  navigateToNews(news: News): void {
    this.router.navigate(["/news", news.id]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  viewAllCategory(category: string): void {
    this.currentFilter.set({ category, published: true })
  }

  resetFilters(): void {
    this.currentFilter.set({})
  }

  hasActiveFilters(): boolean {
    const filter = this.currentFilter()
    return !!(filter.search || filter.category)
  }

  getCategoryNews(category: string): News[] {
    return this.allNews().filter((news) => news.category === category && news.is_published)
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

  getCategoryIconClass(category: string): string {
    switch (category) {
      case "notice":
        return "bg-gradient-to-br from-blue-500 to-blue-600"
      case "announcement":
        return "bg-gradient-to-br from-green-500 to-green-600"
      case "event":
        return "bg-gradient-to-br from-purple-500 to-purple-600"
      default:
        return "bg-gradient-to-br from-gray-500 to-gray-600"
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

  getCurrentLanguage(): string {
    return this.translate.currentLang || "fr"
  }
  getPhotoUrl(photoPath: string): string {
    return `${environment.StorageUrl}/${photoPath}`
  }
}
