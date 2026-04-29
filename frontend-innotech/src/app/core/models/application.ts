// src/app/models/application.ts
import { ApplicationStatus, Gender } from './types';
export interface Application {
    id?: number;
    first_name: string;
    last_name: string;
    email: string;
    first_name_ar?: string;
    last_name_ar?: string;
    desired_degree_id: number;
    cin?: string;
    passport?: string;
    birth_date: string;
    country: string;
    gender: Gender;
    address?: string;
    phone?: string;
    previous_degree?: string;
    graduation_year?: string;
    how_did_you_hear?: string;
    status?: ApplicationStatus;
    rejection_reason?: string;
    created_at?: string;
    updated_at?: string;
  }
  