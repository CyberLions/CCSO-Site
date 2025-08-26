<template>
  <div class="mixer-page min-h-screen">
    <div class="max-w-5xl mx-auto p-6 px-4 text-white text-lg leading-relaxed">
      <h2 class="section-title">&lt;Cyber Networking Mixer/&gt;</h2>

      <p class="mb-4">Looking to connect with professionals in the Cyber Security Industry?</p>

      <p class="mb-4">Join <strong class="text-indigo-300">CCSO</strong> in partnership with the <strong class="text-indigo-300">College of IST</strong> for a relaxed, post-career fair event designed to help students network with industry leaders in a casual environment.</p>

      <div class="bg-black/50 border-2 border-blue-600 rounded-md p-6 my-8">
        <p class="mb-4"><strong class="text-indigo-300">Date:</strong> Monday, September 9, 2025</p>
        <p class="mb-4"><strong class="text-indigo-300">Time:</strong> 4:00 PM to 6:00 PM</p>
        <p class="mb-4"><strong class="text-indigo-300">Location:</strong> Lions Lair Lounge (008), HUB-Robeson Center</p>
        <p class="mb-0"><strong class="text-indigo-300">Refreshments:</strong> Light food and drinks provided</p>
      </div>

      <p class="mb-4">This is a unique opportunity to:</p>
      <ul class="list-disc ml-8 mb-4">
        <li class="mb-2">Start building meaningful relationships with cybersecurity professionals</li>
        <li class="mb-2">Get exclusive industry insights</li>
        <li class="mb-2">Make a lasting impression outside of the formal career fair setting</li>
      </ul>

      <p class="mb-4"><strong class="text-indigo-300">Recommended for:</strong> Students interested in cybersecurity roles and internships</p>

      <p class="mb-4">
        <a 
          href="https://pennstate-csm.symplicity.com/events/ist_connectFA25/overview" 
          target="_blank"
          rel="noopener noreferrer"
          class="text-indigo-300 font-bold underline hover:text-white transition-colors duration-300"
        >
          View Full List of Attending Employers
        </a>
      </p>

      <p class="mb-4">
        We hope to see you there!<br>
        — <em class="text-gray-300">CCSO Executive Board</em>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MixerView'
}
</script>

<style scoped>
/* Mobile responsiveness matching original CSS */
@media (max-width: 768px) {
  .max-w-5xl {
    font-size: 1.05rem;
  }
}

@media (max-width: 480px) {
  .max-w-5xl {
    font-size: 1rem;
    padding: 1rem 0.5rem;
  }
}
</style>