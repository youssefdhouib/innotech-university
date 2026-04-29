  import { Component, ViewChild, ElementRef } from '@angular/core';
import { ChatbotService } from '@core/services/chatbot.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { TranslateModule } from '@ngx-translate/core';

@Component({
  selector: 'app-chatbot',
  templateUrl: './chatbot.component.html',
  styleUrls: ['./chatbot.component.css'],
  imports: [CommonModule, FormsModule, TranslateModule],
  standalone: true
})
export class ChatbotComponent {
  isOpen = false;
  userInput = '';
  messages: { user: string; bot: string }[] = [];
@ViewChild('chatEnd') chatEnd!: ElementRef;
  constructor(private chatbotService: ChatbotService) {}

  toggleChat() {
    this.isOpen = !this.isOpen;
  }


  scrollToBottom() {
    setTimeout(() => {
      this.chatEnd?.nativeElement?.scrollIntoView({ behavior: 'smooth' });
    }, 100);
  }

  sendMessage() {
    const text = this.userInput.trim();
    if (!text) return;

    this.messages.push({ user: text, bot: 'Typing...' });

    this.chatbotService.sendMessage(text).subscribe({
      next: (res) => {
        this.messages[this.messages.length - 1].bot = res.data.reply;
        this.scrollToBottom();
      },
      error: () => {
        this.messages[this.messages.length - 1].bot = 'Oops, something went wrong.';
        this.scrollToBottom();
      }
    });

    this.userInput = '';
  }
}
