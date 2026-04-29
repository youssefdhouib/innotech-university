export interface Degree {
    id: number;
    name: string;
    level: 'Licence' | 'Mastere';
    cover_image: string;
    translations?: {
      fr?: { name: string }
      en?: { name: string }
      ar?: { name: string }
    }
  }
