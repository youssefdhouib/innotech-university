import { Professor } from './professor';

export interface Department {
  id: number;
  name: string;
  description: string;
  cover_image: string;
  professors?: Professor[];
}
