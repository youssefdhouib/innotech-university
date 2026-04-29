import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: '',
    loadComponent: () => import('./pages/home/home.component').then(m => m.HomeComponent)
  },
  {
    path: 'home',
    loadComponent: () => import('./pages/home/home.component').then(m => m.HomeComponent)
  },
  {
    path: 'preinscription',
    loadComponent: () =>
      import('./pages/preinscription/preinscription.component').then(
        (m) => m.PreinscriptionComponent
      )
  },
  {
    path: 'formulaires/confirm-preinscription/:id',
    loadComponent: () => import('./pages/confirmation/confirmation.component').then(m => m.ConfirmationComponent)
  },
  {
    path: 'contact',
    loadComponent: () => import('./pages/contact/contact.component').then(m => m.ContactComponent)
  },
  {
    path: 'degrees',
    loadComponent: () => import('./pages/degrees/degrees.component').then(m => m.DegreesComponent)
  },
  {
    path: 'degree-detail/:id',
    loadComponent: () => import('./pages/degree-detail/degree-detail.component').then(m => m.DegreeDetailComponent)
  },
  {
    path: "professors",
    loadComponent: () => import("./pages/professors/professors.component").then((m) => m.ProfessorsComponent)
  },
  {
    path: "professors/:profileSlug",
    loadComponent: () =>
      import("./pages/professor-details/professor-details.component").then((m) => m.ProfessorDetailsComponent)
  },
  {
    path: 'departments',
    loadComponent: () => import('./pages/departments/departments.component').then(m => m.DepartmentsComponent)
  },
  {
    path: 'departments/:id',
    loadComponent: () => import('./pages/department-detail/department-detail.component').then(m => m.DepartmentDetailComponent)
  },
  {
    path: 'about',
    loadComponent: () => import('./pages/about/about.component').then(m => m.AboutComponent),
  },
  {
    path: 'news',
    loadComponent: () => import('./pages/news/news.component').then(m => m.NewsComponent)
  },
  {
    path: 'news/:id',
    loadComponent: () => import('./pages/news-details/news-details.component').then(m => m.NewsDetailsComponent)
  },

];
