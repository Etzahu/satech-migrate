<div>
    @if (class_basename($getRecord()) == 'PurchaseRequisition')
        <div>
            <div class="flex">
                {{-- solicita --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->status()->snapshotWhen('revisión por almacén'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
                                    clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Solicita</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->requester->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24"
                                    height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Solicita</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->requester->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- revisa --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->status()->snapshotWhen('aprobado por revisor'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Revisa</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->reviewer->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24"
                                    height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Revisa</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->reviewer->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- aprueba --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->status()->snapshotWhen('aprobado por gerencia'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Aprueba</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->approver->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24"
                                    height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Aprueba</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->approver->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- autoriza --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->status()->snapshotWhen('aprobado por DG'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Autoriza</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->authorizer->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Autoriza</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->approvalChain->authorizer->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- comprador asignado --}}
                <div class="w-1/3 px-6 text-center">
                    {{-- @if ($getRecord()->status()->snapshotWhen('comprador asignado')) TODO:ocurre un error asi --}}
                    @if (filled( $getRecord()->purchaser) )
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Comprador</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->purchaser->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Comprador</h2>
                                <p class="text-xs text-gray-600">
                                    Sin asignar
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div>
            <div class="flex">
                {{-- solicita --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->requisition->status()->snapshotWhen('revisión por almacén'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Solicita</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->requester->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Solicita</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->requester->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- revisa --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->requisition->status()->snapshotWhen('aprobado por revisor'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Revisa</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->reviewer->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Revisa</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->reviewer->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- aprueba --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->requisition->status()->snapshotWhen('aprobado por gerencia'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Aprueba</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->approver->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Aprueba</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->approver->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- autoriza --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->requisition->status()->snapshotWhen('aprobado por DG'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Autoriza</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->authorizer->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Autoriza</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->approvalChain->authorizer->name }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-center flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z" />
                    </svg>
                </div>
                {{-- comprador asignado --}}
                <div class="w-1/3 px-6 text-center">
                    @if ($getRecord()->requisition->status()->snapshotWhen('comprador asignado'))
                        <div class="flex items-center justify-center bg-green-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                    fill-rule="evenodd" clip-rule="evenodd">
                                    <path
                                        d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z" />
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-green-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Comprador</h2>
                                <p class="text-xs text-gray-600">
                                    {{ $getRecord()->requisition->purchaser->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center bg-gray-400 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    width="24" height="24" stroke-width="2" data-darkreader-inline-stroke=""
                                    style="--darkreader-inline-stroke: currentColor;">
                                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                                    <path d="M12 7v5l3 3"></path>
                                    <path d="M19 16v3"></path>
                                    <path d="M19 22v.01"></path>
                                </svg>
                            </div>
                            <div
                                class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-300 rounded-r-lg body-step">
                                <h2 class="text-sm font-bold">Comprador</h2>
                                <p class="text-xs text-gray-600">
                                    Sin asignar
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
