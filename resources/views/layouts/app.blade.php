<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    <nav class="justify-between gap-4 shadow-sm navbar rounded-box shadow-base-300/20">
        <div class="navbar-start">
          <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:9]">
            <button id="dropdown-name" type="button" class="dropdown-toggle btn btn-text btn-circle dropdown-open:bg-base-content/10 dropdown-open:text-base-content" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
              <span class="icon-[tabler--menu-2] size-5"></span>
            </button>
            <ul class="hidden dropdown-menu dropdown-open:opacity-100" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-name">
              <li><a class="dropdown-item" href="#">Link 1</a></li>
              <li><a class="dropdown-item" href="#">Link 2</a></li>
              <li><a class="dropdown-item" href="#">Link 3</a></li>
              <hr class="-mx-2 border-base-content/25" />
              <li><a class="dropdown-item" href="#">Link 4</a></li>
            </ul>
          </div>
        </div>
        <div class="flex items-center navbar-center">
          <a class="text-xl font-bold no-underline link text-base-content link-neutral" href="#">
            FlyonUI
          </a>
        </div>
        <div class="items-center gap-4 navbar-end">
          <button class="btn btn-sm btn-text btn-circle size-8.5" aria-label="Search Button">
            <span class="icon-[tabler--search] size-5.5"></span>
          </button>
          <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
            <button id="dropdown-scrollable" type="button" class="flex items-center dropdown-toggle" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
              <div class="avatar">
                <div class="size-9.5 rounded-full">
                  <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar 1" />
                </div>
              </div>
            </button>
            <ul class="hidden dropdown-menu dropdown-open:opacity-100 min-w-60" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-avatar">
              <li class="gap-2 dropdown-header">
                <div class="avatar">
                  <div class="w-10 rounded-full">
                    <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar" />
                  </div>
                </div>
                <div>
                  <h6 class="text-base font-semibold text-base-content">John Doe</h6>
                  <small class="text-base-content/50">Admin</small>
                </div>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <span class="icon-[tabler--user]"></span>
                  My Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <span class="icon-[tabler--settings]"></span>
                  Settings
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <span class="icon-[tabler--receipt-rupee]"></span>
                  Billing
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <span class="icon-[tabler--help-triangle]"></span>
                  FAQs
                </a>
              </li>
              <li class="gap-2 dropdown-footer">
                <a class="btn btn-error btn-soft btn-block" href="#">
                  <span class="icon-[tabler--logout]"></span>
                  Sign out
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
  </body>
</html>
