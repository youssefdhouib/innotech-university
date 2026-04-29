import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { delay, map } from 'rxjs/operators';
import { environment } from '@environments/environment';
import { Professor } from '../models/professor';

export interface Stat {
  icon: string;
  count: string;
  labelKey: string;
}

export interface Event {
  id: number;
  image: string;
  titleKey: string;
  descriptionKey: string;
  date: string;
}

export interface Program {
  id: number;
  titleKey: string;
  descriptionKey: string;
  route: string;
  image: string;
}

export interface Teacher {
  id: number;
  name: string;
  image: string;
  specialization: string;
  slug: string;
}

@Injectable({
  providedIn: 'root'
})
export class HomeService {

  constructor(private http: HttpClient) { }

  getStats(): Observable<Stat[]> {
    const stats: Stat[] = [
      { icon: 'pi pi-users', count: '50+', labelKey: 'HOME.STATS.TEACHERS' },
      { icon: 'pi pi-book', count: '12+', labelKey: 'HOME.STATS.RESEARCH' },
      { icon: 'pi pi-building', count: '2+', labelKey: 'HOME.STATS.DEPARTMENTS' }
    ];
    return of(stats).pipe(delay(500));
  }

getEvents(): Observable<Event[]> {
  const events: Event[] = [
    {
      id: 1,
      image: '/assets/images/home/events/event1.jpg',
      titleKey: 'HOME.EVENTS.AI_HACKATHON.TITLE',
      descriptionKey: 'HOME.EVENTS.AI_HACKATHON.DESCRIPTION',
      date: '2024-10-12'
    },
    {
      id: 2,
      image: '/assets/images/home/events/event2.jpg',
      titleKey: 'HOME.EVENTS.IT_CAREER_FAIR.TITLE',
      descriptionKey: 'HOME.EVENTS.IT_CAREER_FAIR.DESCRIPTION',
      date: '2024-11-05'
    },
    {
      id: 3,
      image: '/assets/images/home/events/event3.png',
      titleKey: 'HOME.EVENTS.ANNUAL_SPORTS.TITLE',
      descriptionKey: 'HOME.EVENTS.ANNUAL_SPORTS.DESCRIPTION',
      date: '2024-12-15'
    }
  ];
  return of(events).pipe(delay(300));
}



  getPrograms(): Observable<Program[]> {
    const programs: Program[] = [
      {
        id: 1,
        titleKey: 'HOME.PROGRAMS.ALL.TITLE',
        descriptionKey: 'HOME.PROGRAMS.ALL.DESCRIPTION',
        route: '/degrees',
        image: '/assets/images/home/programs/allprograms.jpg'
      },
      {
        id: 2,
        titleKey: 'HOME.PROGRAMS.LICENCE.TITLE',
        descriptionKey: 'HOME.PROGRAMS.LICENCE.DESCRIPTION',
        route: '/degrees?filter=licence',
        image: '/assets/images/home/programs/licence.jpg'
      },
      {
        id: 3,
        titleKey: 'HOME.PROGRAMS.MASTERS.TITLE',
        descriptionKey: 'HOME.PROGRAMS.MASTERS.DESCRIPTION',
        route: '/degrees?filter=masters',
        image: '/assets/images/home/programs/master.jpg'
      }
    ];
    return of(programs).pipe(delay(400));
  }

  getTeachers(): Observable<Teacher[]> {
    return this.http.get<{ data: Professor[] }>(`${environment.apiUrl}/professors`).pipe(
      map(res => {
        return res.data.slice(0, 6).map(p => ({
          id: p.id,
          name: `${p.grade} ${p.first_name} ${p.last_name}`,
          image: `${environment.StorageUrl}/${p.photo_url}`,
          specialization: p.speciality,
          slug: p.profile_slug
        }));
      })
    );
  }
}
