import { Department } from "./department";

export interface Professor {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  speciality: string;
  grade: string;
  profile_slug: string;
  photo_url: string;
  department_id: number;
  cv_attached_file: string;
  department?: Department; // for eager-loaded relationship
}
