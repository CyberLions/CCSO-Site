export default {
  routes: [
    {
      method: 'GET',
      path: '/calendar-proxy/:calendarId',
      handler: 'calendar-proxy.fetchCalendar',
      config: {
        policies: [],
        middlewares: [],
        auth: false,
      },
    },
  ],
}; 