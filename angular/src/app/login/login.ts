import { Component } from '@angular/core';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  templateUrl: './login.html',
  styleUrl: './login.css',
  imports: [NgIf]
})
export class LoginComponent {
  isSignupMode = false;

  toggleMode() {
    this.isSignupMode = !this.isSignupMode;
  }
}
