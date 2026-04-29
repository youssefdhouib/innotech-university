import { Component, type OnInit } from "@angular/core"
import { CommonModule } from "@angular/common"
import { Router, RouterModule } from "@angular/router"
import { TranslateModule, TranslateService } from "@ngx-translate/core"

@Component({
  selector: "app-footer",
  standalone: true,
  imports: [CommonModule, RouterModule, TranslateModule],
  templateUrl: "./footer.component.html",
  styleUrls: ["./footer.component.css"],
  host: {
    "[class.footer-bottom-responsive]": "true",
  },
})
export class FooterComponent implements OnInit {
  currentYear = new Date().getFullYear()
  currentLanguage = "fr"

  // Quick Links
  quickLinks = [
    { label: "FOOTER.LINKS.HOME", route: "/home", icon: "pi pi-home" },
    { label: "FOOTER.LINKS.ABOUT", route: "/about", icon: "pi pi-info-circle" },
    { label: "FOOTER.LINKS.DEGREES", route: "/degrees", icon: "pi pi-book" },
    { label: "FOOTER.LINKS.TEACHERS", route: "/teachers", icon: "pi pi-users" },
    { label: "FOOTER.LINKS.DEPARTMENTS", route: "/departments", icon: "pi pi-building" },
    { label: "FOOTER.LINKS.NEWS", route: "/news", icon: "pi pi-megaphone" },
  ]

  // Students Services
  studentsServices = [
    { label: "FOOTER.STUDENTS_SERVICES.EXTRANET", route: "/extranet", icon: "pi pi-globe" },
    { label: "FOOTER.STUDENTS_SERVICES.STUDENT_LIFE", route: "/student-life", icon: "pi pi-users" },
    { label: "FOOTER.LINKS.CONTACT", route: "/contact", icon: "pi pi-envelope" },
    { label: "FOOTER.STUDENTS_SERVICES.SCHOLARSHIPS", route: "/scholarships", icon: "pi pi-money-bill" },
    { label: "FOOTER.STUDENTS_SERVICES.LIBRARY", route: "/library", icon: "pi pi-book" },
    { label: "FOOTER.STUDENTS_SERVICES.CALENDAR", route: "/calendar", icon: "pi pi-calendar" },
  ]



  // Social Media Links
  socialLinks = [
    { name: "Facebook", icon: "pi pi-facebook", url: "https://facebook.com/InnoTechuniversity", color: "#1877F2" },
    { name: "LinkedIn", icon: "pi pi-linkedin", url: "https://linkedin.com/school/InnoTechuniversity", color: "#0A66C2" },
    { name: "Instagram", icon: "pi pi-instagram", url: "https://instagram.com/InnoTechuniversity", color: "#E4405F" },
    { name: "YouTube", icon: "pi pi-youtube", url: "https://youtube.com/InnoTechuniversity", color: "#FF0000" },
  ]

  // Contact Information
  contactInfo = {
    address: {
      street: "123 University Avenue",
      city: "Tech City",
      state: "TC 12345",
      country: "Country",
    },
    phone: "+1 (555) 123-4567",
    email: "info@test.com",
    fax: "+1 (555) 123-4568",
  }

  constructor(private translate: TranslateService, private router: Router) {}

  ngOnInit() {
    this.currentLanguage = this.translate.currentLang || "en"

    // Subscribe to language changes
    this.translate.onLangChange.subscribe((event) => {
      this.currentLanguage = event.lang
    })
  }

  // Navigate to route and scroll to top
  navigateToRoute(route: string) {
    this.router.navigate([route]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  // Navigate to external link (for legal pages)
  navigateToExternalRoute(route: string) {
    this.router.navigate([route]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  openSocialLink(url: string) {
    window.open(url, "_blank", "noopener,noreferrer")
  }

  openMap() {
    // Open Google Maps with university location
    const mapUrl = "https://maps.google.com/?q=InnoTech+University"
    window.open(mapUrl, "_blank", "noopener,noreferrer")
  }

  scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" })
  }
}
