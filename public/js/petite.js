PetiteVue.createApp({
  $delimiters: ['$[', ']'],
  // Hamburger menu toggle
  mnuToggle: false,
  menuToggle() {
    this.mnuToggle = !this.mnuToggle
  },
  
  info: {
    titleText: "Service alert",
    bodyText: "Heavy traffic, expect delays",
    msgSeverity: 2
  }
}).mount("#wrapper")
