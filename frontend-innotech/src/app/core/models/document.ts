// src/app/models/document.ts
export interface Document {
    id?: number;
    application_id: number;
    type_id: number;
    file_path: string;
    status?: string;
    created_at?: string;
    updated_at?: string;
  }
  