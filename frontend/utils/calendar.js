import ICAL from 'ical.js'
import { buildStrapiUrl } from './api.js'

// Calendar configuration with colors and IDs
export const CALENDAR_CONFIG = {
  blueTeam: {
    id: 'enqQ8jmjJrpyPFjG',
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/enqQ8jmjJrpyPFjG?export',
    name: 'Blue Team',
    color: '#3B82F6', // Blue
    bgColor: '#DBEAFE'
  },
  redTeam: {
    id: 'g2zxnZC5degDENYs',
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/g2zxnZC5degDENYs?export',
    name: 'Red Team',
    color: '#EF4444', // Red
    bgColor: '#FEE2E2'
  },
  general: {
    id: 'HtiSPQPGJWnRqi4m',
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/HtiSPQPGJWnRqi4m?export',
    name: 'General',
    color: '#10B981', // Green
    bgColor: '#D1FAE5'
  },
  ctfs: {
    id: 'cFLaji4Gx8YXb6R6',
    url: 'https://nextcloud.psuccso.org/remote.php/dav/public-calendars/cFLaji4Gx8YXb6R6?export',
    name: 'CTFs',
    color: '#D3A967', // Yellow
    bgColor: '#d3a96729'
  }
}

// Fetch ICS data from URL using Strapi CORS proxy
async function fetchICSData(url, calendarId) {
  try {
    // Use our Strapi CORS proxy to bypass CORS restrictions
    // Use the same API URL pattern as other API calls
    const proxyUrl = buildStrapiUrl(`/calendar-proxy/${calendarId}`)
    
    // Include API token in headers like other Strapi requests
    const STRAPI_API_TOKEN = import.meta.env.NUXT_STRAPI_API_TOKEN
    
    const response = await fetch(proxyUrl, {
      headers: {
        'Authorization': `Bearer ${STRAPI_API_TOKEN}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      }
    })
    
    if (!response.ok) {
      throw new Error(`Failed to fetch calendar via proxy: ${response.status}`)
    }
    
    return await response.text()
  } catch (error) {
    console.error('Error fetching ICS data:', error)
    return null
  }
}

// Expansion range for recurring events: 1 year in the past to 2 years in the future
function getExpansionRange() {
  const now = new Date()
  const rangeStart = new Date(now)
  rangeStart.setFullYear(rangeStart.getFullYear() - 1)
  const rangeEnd = new Date(now)
  rangeEnd.setFullYear(rangeEnd.getFullYear() + 2)
  return { rangeStart, rangeEnd }
}

// Convert one ICAL occurrence into our event shape
function occurrenceToEvent(event, details, calendarKey, occurrenceId) {
  const start = details.startDate.toJSDate()
  const end = details.endDate.toJSDate()
  return {
    id: occurrenceId,
    title: event.summary || 'Untitled Event',
    description: event.description || '',
    start,
    end,
    location: event.location || '',
    calendar: calendarKey,
    calendarName: CALENDAR_CONFIG[calendarKey].name,
    color: CALENDAR_CONFIG[calendarKey].color,
    bgColor: CALENDAR_CONFIG[calendarKey].bgColor
  }
}

// Expand a single vevent (recurring or not) into an array of event objects
function expandVEvent(vevent, calendarKey) {
  try {
    const event = new ICAL.Event(vevent)
    const uid = event.uid || `${calendarKey}-${Date.now()}-${Math.random()}`
    const { rangeStart, rangeEnd } = getExpansionRange()

    if (event.isRecurring()) {
      const occurrences = []
      const iter = event.iterator()
      let next
      while ((next = iter.next())) {
        const occDate = next.toJSDate()
        if (occDate > rangeEnd) break
        if (occDate < rangeStart) continue
        const details = event.getOccurrenceDetails(next)
        const occurrenceId = `${uid}-${next.toString()}`
        occurrences.push(occurrenceToEvent(event, details, calendarKey, occurrenceId))
      }
      return occurrences
    }

    const start = event.startDate.toJSDate()
    const end = event.endDate.toJSDate()
    if (start > rangeEnd || end < rangeStart) return []
    return [occurrenceToEvent(event, { startDate: event.startDate, endDate: event.endDate }, calendarKey, uid)]
  } catch (eventError) {
    console.warn('Failed to parse individual event:', eventError)
    return []
  }
}

// Parse ICS data and convert to JSON (expanding recurring events into occurrences)
function parseICSData(icsData, calendarKey) {
  try {
    if (!icsData || icsData.trim() === '') {
      console.warn(`Empty ICS data for ${calendarKey}`)
      return []
    }

    const jcalData = ICAL.parse(icsData)
    const comp = new ICAL.Component(jcalData)
    const vevents = comp.getAllSubcomponents('vevent')

    const events = vevents.flatMap(vevent => expandVEvent(vevent, calendarKey))
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
      const icsData = await fetchICSData(config.url, config.id)
      if (icsData) {
        const events = parseICSData(icsData, key)
        allEvents.push(...events)
      } else {
        console.warn(`No data received for ${config.name}`)
      }
    } catch (error) {
      console.error(`Failed to process calendar ${config.name}:`, error)
    }
  }
  
  const sortedEvents = allEvents.sort((a, b) => new Date(a.start) - new Date(b.start))
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