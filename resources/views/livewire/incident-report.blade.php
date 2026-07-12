<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Log Incident</h2>
        <p class="text-gray-500 text-sm mt-1">Submit a field report. Data syncs automatically.</p>
    </div>

    @if($successMessage)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-bold text-sm">Report filed successfully.</span>
        </div>
    @endif

    <form wire:submit="submitReport" class="space-y-5">
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Suspect ID (Optional)</label>
            <input type="text" wire:model="suspectId" placeholder="Matric or Staff Number" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-600 focus:border-transparent transition">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Incident Type</label>
            <select wire:model="incidentType" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-600 focus:border-transparent transition">
                <option value="">Select an infraction...</option>
                <option value="Impersonation">Examination Impersonation</option>
                <option value="Forgery">Document Forgery</option>
                <option value="Violence">Physical Altercation</option>
                <option value="Contraband">Prohibited Items</option>
                <option value="Other">Other Infraction</option>
            </select>
            @error('incidentType') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Description</label>
            <textarea wire:model="description" rows="4" placeholder="Detail the event, location, and individuals involved..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-600 focus:border-transparent transition resize-none"></textarea>
            @error('description') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg transition flex justify-center items-center">
            <span wire:loading.remove wire:target="submitReport">Submit Official Report</span>
            <span wire:loading wire:target="submitReport">Filing...</span>
        </button>
    </form>
</div>