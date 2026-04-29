import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-page-header',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './page-header.component.html',
  styleUrls: ['./page-header.component.css']
})
export class PageHeaderComponent {
  @Input() subtitle!: string;
  @Input() title!: string;
  @Input() description!: string;
  @Input() backgroundImage: string = '/assets/images/bannerpages.jpg'; // default fallback
}
