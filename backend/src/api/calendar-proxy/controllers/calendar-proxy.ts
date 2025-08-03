import { Context } from 'koa';

export default {
  async fetchCalendar(ctx: Context) {
    try {
      const { calendarId } = ctx.params;
      
      if (!calendarId) {
        return ctx.badRequest('Calendar ID is required');
      }

      const nextcloudUrl = `https://nextcloud.psuccso.org/remote.php/dav/public-calendars/${calendarId}?export`;
      
      const response = await fetch(nextcloudUrl, {
        method: 'GET',
        headers: {
          'User-Agent': 'PSUCCSO-Calendar-Proxy/1.0',
        },
      });

      if (!response.ok) {
        return ctx.notFound('Calendar not found or not accessible');
      }

      const calendarData = await response.text();
      
      // Set proper content type for calendar data
      ctx.set('Content-Type', 'text/calendar; charset=utf-8');
      
      ctx.body = calendarData;
    } catch (error) {
      console.error('Error fetching calendar:', error);
      ctx.internalServerError('Failed to fetch calendar data');
    }
  }
}; 