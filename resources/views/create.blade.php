<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Certificates') }}
        </h2>
    </x-slot>

    <div class="py-5 px-10">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Group Certificate Generation</h3>
              <p class="mt-1 text-sm text-gray-600">
                Generate certificates for a group list of students using an excel or csv file
              </p>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="/certificates/file-store" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="shadow sm:rounded-md sm:overflow-hidden">
                {{-- <div class="flex flex-col flex-grow mb-3"> --}}
                  <div x-data="{ files: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-white  border-gray-50 border-solid rounded-md hover:shadow-outline-gray">
                      <input type="file" multiple
                            name="file"
                             class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                             x-on:change="files = $event.target.files; console.log($event.target.files);"
                             x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                      >
                      <template x-if="files !== null">
                          <div class="flex flex-col space-y-1">
                              <template x-for="(_,index) in Array.from({ length: 1 })">
                                  <div class="flex flex-row items-center space-x-2">
                                      {{-- <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
                                      <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                      <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
                                      <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template> --}}
                                      <span class="font-medium text-gray-900" x-text="files[index].name">Uploading</span>
                                      {{-- <span class="text-xs self-end text-gray-500" x-text="filesize(files[index].size)">...</span> --}}
                                  </div>
                              </template>
                          </div>
                      </template>
                      <template x-if="files === null">
                          <div class="flex flex-col space-y-2 items-center justify-center">
                              <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                              <p class="text-gray-700">Drag your files here or click in this area.</p>
                              <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a>
                          </div>
                      </template>
                  </div>
                {{-- </div> --}}
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Upload File
                  </button>
                  <button id="cancel" class="ml-3 rounded-sm px-3 py-1 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                    Cancel
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>



      <div class="hidden sm:block" aria-hidden="true">
        <div class="py-5">
          <div class="border-t border-gray-200"></div>
        </div>
      </div>
      
    <div class="py-5 px-10">
      <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Single Certificate Generation</h3>
              <p class="mt-1 text-sm text-gray-600">
                  Generate a single certificate using this form 
              </p>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="/certificates/store" method="POST">
              @csrf
              <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-12 sm:col-span-6">
                      <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                      <input type="text" name="name" id="ame" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
      
                    <div class="col-span-6 sm:col-span-4">
                      <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                      <input type="text" name="email" id="email" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
      
                    <div class="col-span-6 sm:col-span-3">
                      <label for="course" class="block text-sm font-medium text-gray-700">Course Name</label>
                      <select id="course" name="course" autocomplete="course" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option>Scratch</option>
                        <option>Web Design</option>
                        <option>Data Science</option>
                      </select>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="module" class="block text-sm font-medium text-gray-700">Module Name</label>
                        <select id="module" name="module" autocomplete="module" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          <option>Web Design-1 (HTML CSS)</option>
                          <option>Web Design-2 (JavaScript)</option>
                          <option>Web Design-3 (PHP & SQL)</option>
                        </select>
                      </div>
                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                      <label for="c_date" class="block text-sm font-medium text-gray-700">Date of Completion</label>
                      <input type="date" name="c_date" id="c_date" autocomplete="c_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                  </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>
