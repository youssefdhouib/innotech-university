import { Component,  OnInit,  OnDestroy, signal } from "@angular/core"
import { CommonModule } from "@angular/common"
import { Router } from "@angular/router"
import { TranslateModule,    TranslateService } from "@ngx-translate/core"
import { Subject } from "rxjs"

import   { LoaderService } from "@core/services/loader.service"
import   { NotificationService } from "@core/services/notification.service"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"

interface Value {
  id: number
  title: string
  description: string
  iconPath: string
}

interface WhyChooseReason {
  id: number
  title: string
  description: string
  iconPath: string
}

@Component({
  selector: "app-about",
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent, PageHeaderComponent],
  templateUrl: "./about.component.html",
  styleUrls: ["./about.component.css"],
})
export class AboutComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  // Using Angular 19 signals
  isLoading = signal<boolean>(true)
  values = signal<Value[]>([])
  whyChooseReasons = signal<WhyChooseReason[]>([])

  constructor(
    private router: Router,
    private translate: TranslateService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
  ) {}

  ngOnInit(): void {
    this.initializeData()
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  private initializeData(): void {
    this.loaderService.show()
    this.isLoading.set(true)

    // Initialize values data
    const valuesData: Value[] = [
      {
        id: 1,
        title: "ABOUT.VALUES.INNOVATION.TITLE",
        description: "ABOUT.VALUES.INNOVATION.DESCRIPTION",
        iconPath:
          "M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z",
      },
      {
        id: 2,
        title: "ABOUT.VALUES.EXCELLENCE.TITLE",
        description: "ABOUT.VALUES.EXCELLENCE.DESCRIPTION",
        iconPath:
          "M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z",
      },
      {
        id: 3,
        title: "ABOUT.VALUES.OPENNESS.TITLE",
        description: "ABOUT.VALUES.OPENNESS.DESCRIPTION",
        iconPath:
          "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
      },
      {
        id: 4,
        title: "ABOUT.VALUES.COLLABORATION.TITLE",
        description: "ABOUT.VALUES.COLLABORATION.DESCRIPTION",
        iconPath:
          "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
      },
    ]

    // Initialize why choose reasons data
    const whyChooseData: WhyChooseReason[] = [
      {
        id: 1,
        title: "ABOUT.WHY_CHOOSE.ACADEMIC_EXCELLENCE.TITLE",
        description: "ABOUT.WHY_CHOOSE.ACADEMIC_EXCELLENCE.DESCRIPTION",
        iconPath:
          "M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z",
      },
      {
        id: 2,
        title: "ABOUT.WHY_CHOOSE.TECHNOLOGICAL_INNOVATION.TITLE",
        description: "ABOUT.WHY_CHOOSE.TECHNOLOGICAL_INNOVATION.DESCRIPTION",
        iconPath:
          "M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z",
      },
      {
        id: 3,
        title: "ABOUT.WHY_CHOOSE.EXPERT_FACULTY.TITLE",
        description: "ABOUT.WHY_CHOOSE.EXPERT_FACULTY.DESCRIPTION",
        iconPath:
          "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z",
      },
      {
        id: 4,
        title: "ABOUT.WHY_CHOOSE.INTERNATIONAL_PARTNERSHIPS.TITLE",
        description: "ABOUT.WHY_CHOOSE.INTERNATIONAL_PARTNERSHIPS.DESCRIPTION",
        iconPath:
          "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
      },
    ]

    this.values.set(valuesData)
    this.whyChooseReasons.set(whyChooseData)

    // Simulate loading time
    setTimeout(() => {
      this.finishLoading()
    }, 1000)
  }

  private finishLoading(): void {
    this.isLoading.set(false)
    this.loaderService.hide()
  }

  getCurrentLanguage(): string {
    return this.translate.currentLang || "en"
  }

  navigateToDepartments(): void {
    this.router.navigate(["/departments"]).then(() => {
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  openContactForm(): void {
    this.router.navigate(["/contact"]).then(() => {
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  trackByValueId(index: number, value: Value): number {
    return value.id
  }

  trackByReasonId(index: number, reason: WhyChooseReason): number {
    return reason.id
  }

  // Enhanced icon methods for PrimeNG icons
  getValueIcon(id: number): string {
    switch (id) {
      case 1:
        return "pi pi-lightbulb"
      case 2:
        return "pi pi-star"
      case 3:
        return "pi pi-globe"
      case 4:
        return "pi pi-users"
      default:
        return "pi pi-circle"
    }
  }

  getReasonIcon(id: number): string {
    switch (id) {
      case 1:
        return "pi pi-graduation-cap"
      case 2:
        return "pi pi-cog"
      case 3:
        return "pi pi-user-edit"
      case 4:
        return "pi pi-sitemap"
      default:
        return "pi pi-circle"
    }
  }
}
