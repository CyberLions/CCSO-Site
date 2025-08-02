import ICAL from 'ical.js'

// Calendar configuration with colors
export const CALENDAR_CONFIG = {
  blueTeam: {
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/enqQ8jmjJrpyPFjG?export',
    name: 'Blue Team',
    color: '#3B82F6', // Blue
    bgColor: '#DBEAFE'
  },
  redTeam: {
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/g2zxnZC5degDENYs?export',
    name: 'Red Team',
    color: '#EF4444', // Red
    bgColor: '#FEE2E2'
  },
  general: {
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/HtiSPQPGJWnRqi4m?export',
    name: 'General',
    color: '#10B981', // Green
    bgColor: '#D1FAE5'
  },
  ctfs: {
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/cFLaji4Gx8YXb6R6?export',
    name: 'CTFs',
    color: '#8B5CF6', // Purple
    bgColor: '#EDE9FE'
  }
}

// Fetch ICS data from URL using CORS proxy only in development
async function fetchICSData(url) {
  try {
    // In development, use CORS proxy; in production, fetch directly
    const isDevelopment = import.meta.env.DEV
    
    if (isDevelopment) {
      // Use CORS proxy to bypass CORS restrictions in development
      const proxyUrl = `https://api.allorigins.win/raw?url=${encodeURIComponent(url)}`
      const response = await fetch(proxyUrl)
      
      if (!response.ok) {
        throw new Error(`Failed to fetch calendar via proxy: ${response.status}`)
      }
      
      return await response.text()
    } else {
      // In production, fetch directly
      const response = await fetch(url)
      
      if (!response.ok) {
        throw new Error(`Failed to fetch calendar: ${response.status}`)
      }
      
      return await response.text()
    }
  } catch (error) {
    console.error('Error fetching ICS data:', error)
    return null
  }
}

// Parse ICS data and convert to JSON
function parseICSData(icsData, calendarKey) {
  try {
    if (!icsData || icsData.trim() === '') {
      console.warn(`Empty ICS data for ${calendarKey}`)
      return []
    }
    
    const jcalData = ICAL.parse(icsData)
    const comp = new ICAL.Component(jcalData)
    const vevents = comp.getAllSubcomponents('vevent')
    
    const events = vevents.map(vevent => {
      try {
        const event = new ICAL.Event(vevent)
        const start = event.startDate.toJSDate()
        const end = event.endDate.toJSDate()
        
        return {
          id: event.uid || `${calendarKey}-${Date.now()}-${Math.random()}`,
          title: event.summary || 'Untitled Event',
          description: event.description || '',
          start: start,
          end: end,
          location: event.location || '',
          calendar: calendarKey,
          calendarName: CALENDAR_CONFIG[calendarKey].name,
          color: CALENDAR_CONFIG[calendarKey].color,
          bgColor: CALENDAR_CONFIG[calendarKey].bgColor
        }
      } catch (eventError) {
        console.warn('Failed to parse individual event:', eventError)
        return null
      }
    }).filter(event => event !== null)
    
    return events
  } catch (error) {
    console.error('Error parsing ICS data for', calendarKey, ':', error)
    return []
  }
}

// Fetch and parse all calendars
export async function fetchAllCalendars() {
  const allEvents = []
  
  for (const [key, config] of Object.entries(CALENDAR_CONFIG)) {
    try {
      console.log(`Fetching calendar: ${config.name}`)
      const icsData = await fetchICSData(config.url)
      if (icsData) {
        const events = parseICSData(icsData, key)
        console.log(`Parsed ${events.length} events from ${config.name}`)
        allEvents.push(...events)
      } else {
        console.warn(`No data received for ${config.name}`)
      }
    } catch (error) {
      console.error(`Failed to process calendar ${config.name}:`, error)
    }
  }
  
  const sortedEvents = allEvents.sort((a, b) => new Date(a.start) - new Date(b.start))
  console.log(`Total events loaded: ${sortedEvents.length}`)
  return sortedEvents
}

// Get events for a specific date
export function getEventsForDate(events, date) {
  const targetDate = new Date(date)
  targetDate.setHours(0, 0, 0, 0)
  
  return events.filter(event => {
    const eventDate = new Date(event.start)
    eventDate.setHours(0, 0, 0, 0)
    return eventDate.getTime() === targetDate.getTime()
  })
}

// Get events for a specific month
export function getEventsForMonth(events, year, month) {
  return events.filter(event => {
    const eventDate = new Date(event.start)
    return eventDate.getFullYear() === year && eventDate.getMonth() === month
  })
}

// Group events by date for month view
export function groupEventsByDate(events, year, month) {
  const grouped = {}
  
  events.forEach(event => {
    const eventDate = new Date(event.start)
    const eventYear = eventDate.getFullYear()
    const eventMonth = eventDate.getMonth()
    const eventDay = eventDate.getDate()
    
    // Only include events from the specified year and month
    if (eventYear === year && eventMonth === month) {
      if (!grouped[eventDay]) {
        grouped[eventDay] = []
      }
      grouped[eventDay].push(event)
    }
  })
  
  return grouped
}

// Format time for display
export function formatTime(date) {
  return new Date(date).toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

// Format date for display
export function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric'
  })
}