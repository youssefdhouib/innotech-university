// src/app/core/models/program.ts
export interface Program {
  id: number
  name: string
  degree_id: number
  description: string
  attached_file?: string | null
  attached_file_url?: string | null
  created_at?: string
  updated_at?: string
}

// Interface for parsed description content
export interface ProgramDescription {
  intro: string
  modules: string[]
}

// Helper function to parse description JSON
export function parseProgramDescription(description: string): ProgramDescription {
  try {
    const parsed = JSON.parse(description)
    return {
      intro: parsed.intro || "",
      modules: Array.isArray(parsed.modules) ? parsed.modules : [],
    }
  } catch (error) {
    console.error("Error parsing program description:", error)
    return {
      intro: description || "",
      modules: [],
    }
  }
}
