import { Component,    OnInit,   OnDestroy, signal } from "@angular/core"
import {   FormBuilder, Validators, ReactiveFormsModule,   FormGroup } from "@angular/forms"
import { CommonModule } from "@angular/common"
import {   TranslateService, TranslateModule } from "@ngx-translate/core"
import { Subject } from "rxjs"

import   { ContactService } from "@core/services/contact.service"
import   { NotificationService } from "@core/services/notification.service"
import   { LoaderService } from "@core/services/loader.service"
import { LoaderComponent } from "@shared/components/loader/loader.component"
import { PageHeaderComponent } from "@shared/components/page-header/page-header.component"

@Component({
  selector: "app-contact",
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, TranslateModule, LoaderComponent],
  templateUrl: "./contact.component.html",
  styleUrls: ["./contact.component.css"],
})
export class ContactComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>()

  // Using Angular 19 signals
  isLoading = signal<boolean>(true)

  submitting = false
  successMessage = ""
  showSuccessModal = false

  services = ["scolarite", "bibliotheque", "administration"]

  contactForm!: FormGroup

  constructor(
    private fb: FormBuilder,
    private contactService: ContactService,
    private notifier: NotificationService,
    private translate: TranslateService,
    public loaderService: LoaderService,
  ) {
    this.contactForm = this.fb.group({
      name: ["", Validators.required],
      email: ["", [Validators.required, Validators.email]],
      service: ["", Validators.required],
      message: ["", [Validators.required, Validators.minLength(10)]],
    })
  }

  ngOnInit(): void {
    this.initializeComponent()
  }

  ngOnDestroy(): void {
    this.destroy$.next()
    this.destroy$.complete()
  }

  private initializeComponent(): void {
    this.loaderService.show()
    this.isLoading.set(true)

    // Simulate loading time for smooth UX
    setTimeout(() => {
      this.finishLoading()
    }, 1000)
  }

  private finishLoading(): void {
    this.isLoading.set(false)
    this.loaderService.hide()
  }

  onSubmit(): void {
    if (this.contactForm.invalid) {
      this.contactForm.markAllAsTouched()
      console.log("Contact form is invalid, showing error toast...")
      this.notifier.error(this.translate.instant("TOAST.FILL_REQUIRED"))
      return
    }

    const payload = this.contactForm.value
    this.submitting = true
    this.successMessage = ""

    this.contactService.submitContactForm(payload).subscribe({
      next: (res: any) => {
        console.log("Response from backend:", res)
        this.successMessage = res.message ?? this.translate.instant("CONTACT_FORM.SUCCESS")
        this.contactForm.reset()
        this.notifier.success(this.translate.instant("TOAST.SUCCESS"))
      },
      error: (err) => {
        console.error("Full error object:", err)
        this.submitting = false
        if (err?.error?.message) {
          console.error(err.error.message)
        } else {
          this.notifier.error(this.translate.instant("TOAST.ERROR"))
        }
      },
      complete: () => (this.submitting = false),
    })
  }

  getCurrentLanguage(): string {
    return this.translate.currentLang || "en"
  }
}
