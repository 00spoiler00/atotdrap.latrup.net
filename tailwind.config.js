/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class', // Enable dark mode by adding the 'dark' class to elements
  theme: {
    extend: {
      colors: {
        primary: '#f76a48',   // Red
        secondary: '#29b6f6', // Dark gray/black
        accent: '#ff4d4d',    // Lighter red
        error: '#ff5252',     // Error red
        info: '#29b6f6',      // Info blue
        success: '#4caf50',   // Success green
        warning: '#fb8c00',   // Warning orange
      },
    },
  },
  plugins: [],
}
