import { Component, OnInit, OnDestroy } from "@angular/core"
import { CommonModule } from "@angular/common"
import { ActivatedRoute, Router } from "@angular/router"
import { TranslateModule, TranslateService } from "@ngx-translate/core"
import { Subject, takeUntil, finalize, forkJoin } from "rxjs"
import { Location } from "@angular/common"
import { Program, ProgramDescription } from "@core/models/program"
import { DegreeService } from "@core/services/degree.service"
import { ProgramService } from "@core/services/program.service"
import { LoaderService } from "@core/services/loader.service"
import { NotificationService } from "@core/services/notification.service"
import { I18nService } from "@core/i18n/i18n.service"
import { Degree } from "@core/models/degree"

import { LoaderComponent } from "@shared/components/loader/loader.component"

@Component({
  selector: "app-degree-detail",
  standalone: true,
  imports: [CommonModule, TranslateModule, LoaderComponent],
  templateUrl: "./degree-detail.component.html",
  styleUrls: ["./degree-detail.component.css"],
})
export class DegreeDetailComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  degree: Degree | null = null
  programs: Program[] = []
  degreeId: number | null = null

  // Computed properties for template
  allModules: string[] = []
  programsWithFiles: Program[] = []
  introText = ""

  // Program benefits data
  programBenefits: { icon: string, titleKey: string }[] = []
  programBenefitsMap: { [key: string]: { icon: string, titleKey: string }[] } = {
    "Génie Logiciel et Intelligence Artificielle": [
      { icon: "pi pi-book", titleKey: "DEGREE_DETAIL.BENEFITS.ACADEMIC_EXCELLENCE" },
      { icon: "pi pi-lightbulb", titleKey: "DEGREE_DETAIL.BENEFITS.INNOVATION" },
      { icon: "pi pi-briefcase", titleKey: "DEGREE_DETAIL.BENEFITS.EMPLOYABILITY" },
      { icon: "pi pi-cog", titleKey: "DEGREE_DETAIL.BENEFITS.TECHNICAL_EXCELLENCE" },
    ],
    "Big Data et Analyse de Données": [
      { icon: "pi pi-chart-bar", titleKey: "DEGREE_DETAIL.BENEFITS.DATA_INSIGHTS" },
      { icon: "pi pi-chart-line", titleKey: "DEGREE_DETAIL.BENEFITS.ANALYTICS" },
      { icon: "pi pi-users", titleKey: "DEGREE_DETAIL.BENEFITS.MARKET_RELEVANCE" },
      { icon: "pi pi-database", titleKey: "DEGREE_DETAIL.BENEFITS.BIG_DATA_TECHNOLOGIES" },
    ],
    "Systèmes Embarqués et Internet des Objets": [
      { icon: "pi pi-wifi", titleKey: "DEGREE_DETAIL.BENEFITS.IOT_SKILLS" },
      { icon: "pi pi-cog", titleKey: "DEGREE_DETAIL.BENEFITS.EMBEDDED_SYSTEMS" },
      { icon: "pi pi-sitemap", titleKey: "DEGREE_DETAIL.BENEFITS.CONNECTIVITY" },
      { icon: "pi pi-microchip", titleKey: "DEGREE_DETAIL.BENEFITS.HARDWARE_INTEGRATION" },
    ],
    "Mécatronique": [
      { icon: "pi pi-robot", titleKey: "DEGREE_DETAIL.BENEFITS.ROBOTICS" },
      { icon: "pi pi-cog", titleKey: "DEGREE_DETAIL.BENEFITS.AUTOMATION" },
      { icon: "pi pi-sliders-h", titleKey: "DEGREE_DETAIL.BENEFITS.EMBEDDED_ELECTRONICS" },
      { icon: "pi pi-bolt", titleKey: "DEGREE_DETAIL.BENEFITS.SMART_SYSTEMS" },
    ],
    "Ingénierie et Administration des Affaires": [
      { icon: "pi pi-briefcase", titleKey: "DEGREE_DETAIL.BENEFITS.MANAGEMENT_SKILLS" },
      { icon: "pi pi-users", titleKey: "DEGREE_DETAIL.BENEFITS.LEADERSHIP" },
      { icon: "pi pi-wallet", titleKey: "DEGREE_DETAIL.BENEFITS.FINANCIAL_CONTROL" },
      { icon: "pi pi-chart-pie", titleKey: "DEGREE_DETAIL.BENEFITS.MARKET_STRATEGY" },
    ],
    "Sciences des Données Industrielles (Industrial Data Science)": [
      { icon: "pi pi-chart-line", titleKey: "DEGREE_DETAIL.BENEFITS.DATA_ANALYSIS" },
      { icon: "pi pi-industry", titleKey: "DEGREE_DETAIL.BENEFITS.INDUSTRIAL_PROCESS" },
      { icon: "pi pi-sliders-h", titleKey: "DEGREE_DETAIL.BENEFITS.MACHINE_LEARNING" },
      { icon: "pi pi-wrench", titleKey: "DEGREE_DETAIL.BENEFITS.MAINTENANCE_OPTIMIZATION" },
    ],
    "Génie Logiciel et DevOps": [
      { icon: "pi pi-cog", titleKey: "DEGREE_DETAIL.BENEFITS.SOFTWARE_ARCHITECTURE" },
      { icon: "pi pi-sync", titleKey: "DEGREE_DETAIL.BENEFITS.CICD_PIPELINES" },
      { icon: "pi pi-server", titleKey: "DEGREE_DETAIL.BENEFITS.CONTAINERIZATION" },
      { icon: "pi pi-code", titleKey: "DEGREE_DETAIL.BENEFITS.FULL_STACK_DEV" },
    ],
    "Ingénierie Automobile et Test Logiciel": [
      { icon: "pi pi-car", titleKey: "DEGREE_DETAIL.BENEFITS.AUTOMOTIVE_SYSTEMS" },
      { icon: "pi pi-check-square", titleKey: "DEGREE_DETAIL.BENEFITS.SOFTWARE_TESTING" },
      { icon: "pi pi-microchip", titleKey: "DEGREE_DETAIL.BENEFITS.ELECTRONIC_DIAGNOSIS" },
      { icon: "pi pi-shield", titleKey: "DEGREE_DETAIL.BENEFITS.SAFETY_STANDARDS" },
    ],
    "Data et Intelligence Artificielle": [
      { icon: "pi pi-database", titleKey: "DEGREE_DETAIL.BENEFITS.BIG_DATA" },
      { icon: "pi pi-chart-line", titleKey: "DEGREE_DETAIL.BENEFITS.ADVANCED_ANALYTICS" },
      { icon: "pi pi-sliders-h", titleKey: "DEGREE_DETAIL.BENEFITS.MACHINE_LEARNING" },
      { icon: "pi pi-chart-bar", titleKey: "DEGREE_DETAIL.BENEFITS.DATA_VISUALIZATION" },
    ],
    "default": [
      { icon: "pi pi-book", titleKey: "DEGREE_DETAIL.BENEFITS.ACADEMIC_EXCELLENCE" },
      { icon: "pi pi-globe", titleKey: "DEGREE_DETAIL.BENEFITS.SUSTAINABILITY" },
      { icon: "pi pi-users", titleKey: "DEGREE_DETAIL.BENEFITS.STUDENT_SUCCESS" },
      { icon: "pi pi-share-alt", titleKey: "DEGREE_DETAIL.BENEFITS.GLOBAL_OUTREACH" },
    ],
  };


  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private location: Location,
    private degreeService: DegreeService,
    private programService: ProgramService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
    private i18nService: I18nService,
    private translateService: TranslateService,
  ) {}

  ngOnInit(): void {
    this.route.params.pipe(takeUntil(this.destroy$)).subscribe((params) => {
      const id = +params["id"]
      if (id && !isNaN(id)) {
        this.degreeId = id
        this.loadDegreeDetails(id)
      } else {
        this.handleError("Invalid degree ID")
        this.router.navigate(["/degrees"])
      }
    })
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  loadDegreeDetails(id: number): void {
    this.loaderService.show()

    // Load both degree and programs data simultaneously
    forkJoin({
      degree: this.degreeService.getDegreeById(id),
      programs: this.programService.getProgramsByDegreeId(id),
    })
      .pipe(
        takeUntil(this.destroy$),
        finalize(() => this.loaderService.hide()),
      )
      .subscribe({
        next: (data) => {
          this.degree = data.degree
          this.programs = data.programs
          this.processPrograms()
          // Assign programBenefits based on degree name, fallback to default
          const degreeFrName = this.degree?.translations?.fr?.name || "default"
          this.programBenefits = this.programBenefitsMap[degreeFrName] || this.programBenefitsMap["default"]

          console.log("Loaded degree:", this.degree)
          console.log("Loaded programs:", this.programs)
        },
        error: (error) => {
          console.error("Error loading degree details:", error)
          this.handleError("Failed to load degree details")

          // Redirect to degrees page after error
          setTimeout(() => {
            this.router.navigate(["/degrees"])
          }, 3000)
        },
      })
  }
  processPrograms(): void {
    this.allModules = []
    this.programsWithFiles = []
    this.introText = ""

    console.log("Processing programs:", this.programs)

    if (this.programs && this.programs.length > 0) {
      this.programs.forEach((program, index) => {
        const { intro, modules } = this.getProgramDescription(program.description) || { intro: "", modules: [] }

        if (index === 0 && intro) {
          this.introText = intro
        }

        if (Array.isArray(modules)) {
          this.allModules.push(...modules)
        }

        if (program.attached_file) {
          this.programsWithFiles.push(program)
        }
      })

      this.allModules = [...new Set(this.allModules)]
    }

    console.log("Intro text:", this.introText)
    console.log("All modules:", this.allModules)
    console.log("Programs with files:", this.programsWithFiles)
  }

  getProgramDescription(description: string | any): ProgramDescription {
    if (!description) return { intro: "", modules: [] }

    if (typeof description === "string") {
      try {
        const parsed = JSON.parse(description)
        return {
          intro: parsed.intro || parsed.description || "",

          modules: Array.isArray(parsed.modules) ? parsed.modules : [],
        }
      } catch {
        return { intro: description, modules: [] }
      }
    }

    if (typeof description === "object") {
      return {
        intro: description.intro || description.description || "",
        modules: Array.isArray(description.modules) ? description.modules : [],
      }
    }

    return { intro: "", modules: [] }
  }

  downloadFile(fileUrl: string, programName: string): void {
    if (!fileUrl) {
      this.translateService.get("DEGREE_DETAIL.NO_FILE_AVAILABLE").subscribe((message) => {
        this.notificationService.error(message)
      })
      return
    }

    try {
      // Create a temporary anchor element to trigger download
      const link = document.createElement("a")
      link.href = fileUrl
      link.download = `${programName}_program.pdf`
      link.target = "_blank"
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)

      this.translateService.get("DEGREE_DETAIL.DOWNLOAD_STARTED", { name: programName }).subscribe((message) => {
        this.notificationService.success(message)
      })
    } catch (error) {
      console.error("Error downloading file:", error)
      this.translateService.get("DEGREE_DETAIL.DOWNLOAD_ERROR").subscribe((message) => {
        this.notificationService.error(message)
      })
    }
  }

  goBack(): void {
    this.router.navigate(["/degrees"])
  }

  getCurrentLanguage(): string {
    return this.i18nService.currentLang
  }

  trackByProgramId(index: number, program: Program): number {
    return program.id
  }

  private handleError(message: string): void {
    console.error(message)
    this.translateService.get("DEGREE_DETAIL.ERROR_OCCURRED").subscribe((translatedMessage) => {
      this.notificationService.error(translatedMessage)
    })
  }
}
