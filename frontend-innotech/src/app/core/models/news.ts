export interface News {
  id: number;
  title: string;
  description: string;
  category: 'notice' | 'announcement' | 'event';
  is_published: boolean;
  created_at?: string;
  updated_at?: string;
  image_url: string;
  event_date?: string;
  location?: string;
}

export interface NewsFilter {
  category?: string;
  search?: string;
  published?: boolean;
}
