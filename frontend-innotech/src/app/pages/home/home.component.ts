import { Component, OnInit, OnDestroy, HostListener } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, UrlSerializer, UrlTree } from '@angular/router';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MessageService } from 'primeng/api';
import { ToastModule } from 'primeng/toast';
import { Subject, takeUntil, forkJoin } from 'rxjs';
import { LoaderService } from '../../core/services/loader.service';
import { HomeService, Stat,Program, Teacher } from '../../core/services/home.Service';
import { LoaderComponent } from '../../shared/components/loader/loader.component';
import { NotificationService } from "../../core/services/notification.service"
import { NewsService } from '../../core/services/news.service';
import { News } from '../../core/models/news';
import { environment } from '@environments/environment';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    TranslateModule,
    ToastModule,
    LoaderComponent
  ],
  providers: [MessageService],
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit, OnDestroy {
  private destroy$ = new Subject<void>();
  zoomedImage: string | null = null;
  stats: Stat[] = [];
  events: News[] = [];
  programs: Program[] = [];
  teachers: Teacher[] = [];
  showVideoModal: boolean = false;
  safeVideoUrl!: SafeResourceUrl;
  videoVisible = false;
  testimonials = [
    {
      quoteKey: 'HOME.TESTIMONIALS.QUOTE_1',
      authorNameKey: 'HOME.TESTIMONIALS.AUTHOR_NAME_1',
      authorTitleKey: 'HOME.TESTIMONIALS.AUTHOR_TITLE_1',
      image: '/assets/images/home/students/student1.jpg'
    },
    {
      quoteKey: 'HOME.TESTIMONIALS.QUOTE_2',
      authorNameKey: 'HOME.TESTIMONIALS.AUTHOR_NAME_2',
      authorTitleKey: 'HOME.TESTIMONIALS.AUTHOR_TITLE_2',
      image: '/assets/images/home/students/student2.jpg'
    },
    {
      quoteKey: 'HOME.TESTIMONIALS.QUOTE_3',
      authorNameKey: 'HOME.TESTIMONIALS.AUTHOR_NAME_3',
      authorTitleKey: 'HOME.TESTIMONIALS.AUTHOR_TITLE_3',
      image: '/assets/images/home/students/student3.jpg'
    },
    // Add as many as needed
  ];

  currentTestimonialIndex = 0;
  // Founders data
  founders = [
    { name: 'Dr. Ahmed Gomez', image: '/assets/images/home/founders/founder1.jpg' },
    { name: 'Dr. Mohammed Gomez', image: '/assets/images/home/founders/founder2.jpg' },
    { name: 'Dr. Fatima Gomez', image: '/assets/images/home/founders/founder3.jpg' },
    { name: 'Dr. Amina Gomez', image: '/assets/images/home/founders/founder4.jpg' }
  ];

  // Gallery images
  galleryImages = [
    '/assets/images/home/gallery/image1.jpg',
    '/assets/images/home/gallery/image2.jpg',
    '/assets/images/home/gallery/image3.jpg',
    '/assets/images/home/gallery/image4.jpg',
    '/assets/images/home/gallery/image5.jpg',
    '/assets/images/home/gallery/image6.jpg',
    '/assets/images/home/gallery/image7.jpg',
    '/assets/images/home/gallery/image8.jpg'
  ];

  constructor(
    private router: Router,
    private translate: TranslateService,
    private messageService: MessageService,
    private homeService: HomeService,
    public loaderService: LoaderService,
    private notificationService: NotificationService,
    private route: ActivatedRoute,
    private urlSerializer: UrlSerializer,
    private newsService: NewsService,
    private sanitizer: DomSanitizer
  ) {}

  ngOnInit(): void {
    this.loadHomeData();
    this.translate.onLangChange.pipe(takeUntil(this.destroy$)).subscribe(() => {
      this.loadHomeData();
    });
    setInterval(() => {
      this.currentTestimonialIndex = (this.currentTestimonialIndex + 1) % this.testimonials.length;
    }, 5000);
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }
  getEvents(): void {
    this.newsService.getNewsByCategory("event").subscribe((data) => {
      this.events = data.slice(0, 3); // manually limit on frontend
      console.log(this.events);
    });
  }

  loadHomeData(): void {
    this.loaderService.show();

    forkJoin({
      stats: this.homeService.getStats(),
      events: this.homeService.getEvents(),
      programs: this.homeService.getPrograms(),
      teachers: this.homeService.getTeachers()
    }).pipe(
      takeUntil(this.destroy$)
    ).subscribe({
      next: (data) => {
        this.stats = data.stats;
        this.getEvents();
        this.programs = data.programs;
        console.log(this.programs);
        this.teachers = data.teachers;
        this.loaderService.hide();

      },
      error: (error) => {
        console.error('Error loading home data:', error);
        this.loaderService.hide();
        this.notificationService.errorI18n('TOAST.ERROR', 'TOAST.LOAD_ERROR');
      }
    });
  }


  openZoom(image: string): void {
    this.zoomedImage = image;
  }

  closeZoom(): void {
    this.zoomedImage = null;
  }

  @HostListener('document:keydown.escape', ['$event'])
  onEscapePress(event: KeyboardEvent) {
    this.closeZoom();
  }

  navigateToPreregistration(): void {
    this.router.navigate(['/preinscription']);
        // Show info notification for navigation
        this.notificationService.infoI18n(
          this.translate.instant("NAV.NAVIGATION"),
          this.translate.instant("NAV.REDIRECTING_TO_PREREGISTRATION"),
        )
  }

  navigateToPrograms(): void {
    this.router.navigate(['/degrees']).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    });
  }

  navigateToAbout(): void {
    this.router.navigate(['/about']).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    });
  }

  navigateToProgram(route: string): void {
    let navigationPromise;

    if (route.includes('?')) {
      const urlTree: UrlTree = this.urlSerializer.parse(route);
      const path = urlTree.root.children['primary']?.segments.map(it => it.path).join('/') || route.split('?')[0];
      navigationPromise = this.router.navigate([path], { queryParams: urlTree.queryParams });
    } else {
      navigationPromise = this.router.navigate([route]);
    }

    // Force scroll to top after navigation completes
    navigationPromise.then(() => {
      setTimeout(() => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }, 50); // slight delay ensures DOM stabilizes
    });
  }

  navigateToNewsDetails(id: number): void {
    this.router.navigate(['/news', id]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    });
  }

  navigateToTeachers(): void {
    this.router.navigate(['/professors']).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    });
  }

  playVideoTour(): void {
    const url = 'https://www.youtube.com/embed/R3GfuzLMPkA?autoplay=1';
    this.safeVideoUrl = this.sanitizer.bypassSecurityTrustResourceUrl(url);
    this.showVideoModal = true;
  }
  viewTeacherProfile(slug : string) {
    this.router.navigate(['/professors', slug]).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }
  getImageUrl(image: string): string {
    return `${environment.StorageUrl}/${image}`;
  }
  goToAllEvents(): void {
    this.router.navigate(['/news'], {
      queryParams: { category: 'event' }
    }).then(() => {
      // Scroll to top after navigation
      window.scrollTo({ top: 0, behavior: "smooth" })
    });
  }

  }
