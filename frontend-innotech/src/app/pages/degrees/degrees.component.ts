"use client"

import { Component, type OnInit, type OnDestroy, signal } from "@angular/core"
import { CommonModule } from "@angular/common"
import { FormsModule } from "@angular/forms"
import { TranslateModule, TranslateService } from "@ngx-translate/core"
import { Subject, takeUntil, finalize } from "rxjs"
import { DegreeService } from "@core/services/degree.service"
import { I18nService } from "@core/i18n/i18n.service"
import { NotificationService } from "@core/services/notification.service"
import { LoaderService } from "@core/services/loader.service"
import type { Degree } from "@core/models/degree"
import { DegreeCardComponent } from "@shared/components/degree-card/degree-card.component"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { ActivatedRoute, Router, UrlSerializer, UrlTree } from "@angular/router"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"

@Component({
  selector: "app-degrees",
  standalone: true,
  imports: [CommonModule, FormsModule, TranslateModule, DegreeCardComponent, LoaderComponent, PageHeaderComponent],
  templateUrl: "./degrees.component.html",
  styleUrls: ["./degrees.component.css"],
})
export class DegreesComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  degrees: Degree[] = []
  filteredDegrees: Degree[] = []
  searchTerm = ""
  activeFilter: "all" | "licence" | "masters" = "all"
  isLoading = signal<boolean>(true);
  licenceDegrees: Degree[] = []
  mastersDegrees: Degree[] = []

  // Updated tech-focused vision items with translation keys
  visionItems = [
    {
      icon: "M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z",
      titleKey: "DEGREES.VISION.TECH_EXCELLENCE.TITLE",
      descriptionKey: "DEGREES.VISION.TECH_EXCELLENCE.DESCRIPTION",
      title: "Tech Excellence", // Fallback
      description: "Fostering innovation and technical mastery in computer science", // Fallback
    },
    {
      icon: "M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-2.573 1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6",
      titleKey: "DEGREES.VISION.DIGITAL_INNOVATION.TITLE",
      descriptionKey: "DEGREES.VISION.DIGITAL_INNOVATION.DESCRIPTION",
      title: "Digital Innovation", // Fallback
      description: "Leading breakthrough research in AI, ML, and emerging technologies", // Fallback
    },
    {
      icon: "M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6",
      titleKey: "DEGREES.VISION.INDUSTRY_PARTNERSHIP.TITLE",
      descriptionKey: "DEGREES.VISION.INDUSTRY_PARTNERSHIP.DESCRIPTION",
      title: "Industry Partnership", // Fallback
      description: "Connecting students with leading tech companies and startups", // Fallback
    },
    {
      icon: "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
      titleKey: "DEGREES.VISION.GLOBAL_IMPACT.TITLE",
      descriptionKey: "DEGREES.VISION.GLOBAL_IMPACT.DESCRIPTION",
      title: "Global Impact", // Fallback
      description: "Developing solutions that transform industries worldwide", // Fallback
    },
  ]

  constructor(
    private degreeService: DegreeService,     // Inject the DegreeService
    private i18nService: I18nService,         // Inject the I18nService
    private notificationService: NotificationService, // Inject the NotificationService
    public loaderService: LoaderService, // Made public for template access
    private translateService: TranslateService, // Inject the TranslateService
    private router: Router, // Inject the Router
    private route: ActivatedRoute,
    private urlSerializer: UrlSerializer
  ) {}

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      const filter = params['filter'];

      if (filter === 'licence') {
        this.activeFilter = 'licence';
      } else if (filter === 'masters') {
        this.activeFilter = 'masters';
      }
    });
    this.loadDegrees()
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  loadDegrees(): void {
    this.isLoading.set(true);
    this.loaderService.show()

    this.degreeService
      .getAllDegrees()
      .pipe(
        takeUntil(this.destroy$),
        finalize(() => {
          this.isLoading.set(false);
          this.loaderService.hide()
        }),
      )
      .subscribe({
        next: (degrees) => {
          this.degrees = degrees
          this.separateDegreesByLevel()
          this.filterDegrees()

          this.translateService.get("TOAST.LOADED").subscribe((message) => {
            console.log(message)
          })
        },
        error: (error) => {
          console.error("Error loading degrees:", error)

          this.translateService.get("TOAST.ERROR").subscribe((message) => {
            this.notificationService.error(message)
          })
        },
      })
  }

  separateDegreesByLevel(): void {
    this.licenceDegrees = this.degrees.filter((degree) => degree.level === "Licence")
    this.mastersDegrees = this.degrees.filter((degree) => degree.level === "Mastere")
  }

  onSearchChange(): void {
    this.filterDegrees()
  }

  setFilter(filter: "all" | "licence" | "masters"): void {
    this.activeFilter = filter
    this.filterDegrees()
  }

  filterDegrees(): void {
    let filtered = this.degrees

    if (this.activeFilter === "licence") {
      filtered = filtered.filter((degree) => degree.level === "Licence")
    } else if (this.activeFilter === "masters") {
      filtered = filtered.filter((degree) => degree.level === "Mastere")
    }

    if (this.searchTerm.trim()) {
      filtered = filtered.filter((degree) => degree.name.toLowerCase().includes(this.searchTerm.toLowerCase()))
    }

    this.filteredDegrees = filtered
  }

  getCurrentLanguage(): string {
    return this.i18nService.currentLang
  }

  changeLanguage(lang: string): void {
    // Ensure this method is called only once per component lifecycle
    if (this.i18nService.currentLang !== lang) {
      this.i18nService.useLanguage(lang)
    }
  }


  onDegreeCardClick(degree: Degree): void {
    console.log("Degree selected:", degree)

/*     this.translateService.get("DEGREES.DEGREE_SELECTED", { name: degree.name }).subscribe((message) => {
      this.notificationService.success(message)
    }) */

    this.router.navigate(['/degree-detail', degree.id]).then(() => {
      window.scrollTo({ top: 0, behavior: 'smooth' })
    })
  }

  trackByDegreeId(index: number, degree: Degree): number {
    return degree.id
  }
}
