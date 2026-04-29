import { DegreeLevel } from "./types";

// src/app/models/document-type.ts
export interface DocumentType {
    id: number;
    name: string;
    level: DegreeLevel;
    is_required: boolean;
  }
  