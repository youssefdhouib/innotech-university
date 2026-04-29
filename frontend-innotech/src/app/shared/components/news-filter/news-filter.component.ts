import { Component, Input, Output, EventEmitter, type OnInit } from "@angular/core"
import { CommonModule } from "@angular/common"
import { FormsModule } from "@angular/forms"
import { TranslateModule } from "@ngx-translate/core"
import type { NewsFilter } from "../../../core/models/news"

interface CategoryOption {
  value: string
  label: string
  icon: string
  count: number
}

@Component({
  selector: "app-news-filter",
  standalone: true,
  imports: [CommonModule, FormsModule, TranslateModule],
  templateUrl: "./news-filter.component.html",
  styleUrls: ["./news-filter.component.css"],
})
export class NewsFilterComponent implements OnInit {
  @Input() categoryCounts: { [key: string]: number } = {}
  @Output() filterChange = new EventEmitter<NewsFilter>()

  searchTerm = ""
  selectedCategory = ""

  categories: CategoryOption[] = [
    {
      value: "",
      label: "NEWS.ALL_CATEGORIES",
      icon: "pi pi-list",
      count: 0,
    },
    {
      value: "notice",
      label: "NEWS.CATEGORIES.NOTICE",
      icon: "pi pi-info-circle",
      count: 0,
    },
    {
      value: "announcement",
      label: "NEWS.CATEGORIES.ANNOUNCEMENT",
      icon: "pi pi-bell",
      count: 0,
    },
    {
      value: "event",
      label: "NEWS.CATEGORIES.EVENT",
      icon: "pi pi-calendar",
      count: 0,
    },
  ]


  ngOnInit(): void {
    this.updateCategoryCounts()
  }

  updateCategoryCounts(): void {
    this.categories.forEach((category) => {
      if (category.value === "") {
        category.count = Object.values(this.categoryCounts).reduce((sum, count) => sum + count, 0)
      } else {
        category.count = this.categoryCounts[category.value] || 0
      }
    })
  }

  onSearchChange(): void {
    this.emitFilter()
  }

  selectCategory(category: string): void {
    this.selectedCategory = category
    this.emitFilter()
  }

  clearSearch(): void {
    this.searchTerm = ""
    this.emitFilter()
  }

  resetFilters(): void {
    this.searchTerm = ""
    this.selectedCategory = ""
    this.emitFilter()
  }

  hasActiveFilters(): boolean {
    return this.searchTerm.length > 0 || this.selectedCategory.length > 0
  }

  getCategoryButtonClass(categoryValue: string): string {
    const baseClasses = "transition-all duration-300"
    const isSelected = this.selectedCategory === categoryValue

    if (isSelected) {
      switch (categoryValue) {
        case "notice":
          return `${baseClasses} bg-blue-500 text-white shadow-lg`
        case "announcement":
          return `${baseClasses} bg-green-500 text-white shadow-lg`
        case "event":
          return `${baseClasses} bg-purple-500 text-white shadow-lg`
        default:
          return `${baseClasses} bg-[var(--InnoTech-primary)] text-white shadow-lg`
      }
    }

    return `${baseClasses} bg-gray-100 text-gray-700 hover:bg-gray-200`
  }

  private emitFilter(): void {
    const filter: NewsFilter = {
      search: this.searchTerm || undefined,
      category: this.selectedCategory || undefined,
      published: true,
    }
    this.filterChange.emit(filter)
  }
}
