<div>
    <div class="d-flex w-100 pt-3 justify-content-center" x-data="calendar">
        <div class="tip cursor-pointer fw-900">
            <span @click="toggle"><span x-text="name()" class="mr-2"></span><i class="fas fa-caret-down"></i></span>
            <div class="tip-content" x-cloak x-show="open" @click.outside="open = false">
                <div class="px-2" style="margin-top: -4px">
                    <div class="mt-2 mb-3">
                        <div class="btn-group w-100" x-data="{open: false}" @click.outside="open = false">
                            <button class="btn btn-outline-secondary dropdown-toggle text-left p-1" @click="open = !open" type="button" x-text="selectedCalendar.name">
                            </button>
                            <div class="dropdown-menu w-100" :class="open && 'show'">
                                <template x-for="calendar in calendars" :key="calendar.id">
                                    <div class="dropdown-item d-flex align-items-center justify-content-between py-1"
                                         @click="selectedCalendar = calendar; selectCalendar(); open = false">
                                        <span x-text="calendar.name"></span>
                                        <i class="fas fa-check text-success" x-show="calendar.id === selectedCalendar.id"></i>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-2">
                        <div class="d-flex w-100">
                            <div class="btn-group w-100 mr-1" x-data="{open: false}" @click.outside="open = false">
                                <button class="btn btn-outline-secondary dropdown-toggle text-left p-1" @click="open = !open"
                                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" x-text="selectedPeriod.name">
                                </button>
                                <div class="dropdown-menu w-100" style="max-height: 300px; overflow-y: auto" :class="open && 'show'">
                                    <template x-for="period in periods" :key="period.id">
                                        <div class="dropdown-item d-flex align-items-center justify-content-between" @click="selectedPeriod = period; open = false">
                                            <span x-text="period.name"></span>
                                            <i class="fas fa-check text-success" x-show="period.id === selectedPeriod.id"></i>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="btn-group w-50" x-data="{open: false}" @click.outside="open = false" x-show="!hideYears()">
                                <button class="btn btn-outline-secondary dropdown-toggle text-left p-1" @click="open = !open" type="button" x-text="selectedYear">
                                </button>

                                <div class="dropdown-menu w-100" :class="open && 'show'">
                                    <template x-for="year in years" :key="year">
                                        <div class="dropdown-item d-flex align-items-center justify-content-between" @click="selectedYear = year; selectYear();open = false">
                                            <span x-text="year"></span>
                                            <i class="fas fa-check text-success" x-show="year === selectedYear"></i>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-2 pt-1 w-100 border-top">
                    <button class="btn btn-success shadow-0 btn-sm w-100 mt-2" @click="apply" x-bind:disabled="currentPeriodId === selectedPeriod.id">Mostrar Resultados</button>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-xs bg-success-500 border-0 px-2 mx-2" @click="move(-1)" x-bind:disabled="canMove(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="btn btn-xs bg-success-500 border-0 px-2" @click="move(1)" x-bind:disabled="canMove(1)"><i class="fas fa-chevron-right"></i></button>
        </div>

    </div>
</div>

@push('css')
    <style>
        .tip {
            position: relative;
            display: inline-block;
        }

        .tip .tip-content {
            /*visibility: hidden;*/
            width: 200px;
            top: 150%;
            right: -19px;
            margin-left: -60px;
            background-color: #ffffff;
            color: #000000;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgb(30 33 37 / 20%);
            padding: 10px 0 5px;
            font-size: 15px;
            font-weight: 600;
            line-height: 24px;

            position: absolute;
            z-index: 1;
        }

        .tip .tip-content::before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            bottom: 100%;
            border-bottom: 9px solid #d8dfe6;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            right: 13px;
        }

        .tip .tip-content::after {
            bottom: 100%;
            border-bottom: 7px solid #fff;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            right: 15px;
            content: "";
            position: absolute;
            width: 0;
            height: 0;
        }

        /*.tip.open .tip-content {*/
        /*    visibility: visible;*/
        /*    opacity: 1;*/
        /*}*/
    </style>
@endpush

@push('page_script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('calendar', () => ({
                open: false,
                calendars: @js($calendars),
                currentCalendar: null,
                currentPeriod: null,
                currentPeriodId: @js($currentPeriodId),
                selectedCalendar: null,
                selectedPeriod: null,
                selectedYear: null,
                periods: [],
                years: [],
                init() {
                    this.start();
                    this.$watch('open', () => {
                        if (!this.open)
                            this.start();
                    });
                },
                name() {
                    if (this.currentCalendar.frequency === 'yearly')
                        return this.currentPeriod.name;

                    return this.currentPeriod.name + ' ' + new Date(this.currentPeriod.start_date + 'T00:00:00').getFullYear();
                },
                toggle() {
                    this.open = !this.open
                },
                hideYears() {
                    return this.selectedCalendar.frequency === 'yearly';
                },
                start() {
                    for (let i = 0; i < this.calendars.length; i++) {
                        let periods = this.calendars[i].periods;
                        for (let j = 0; j < periods.length; j++) {
                            if (periods[j].id === this.currentPeriodId) {
                                this.currentCalendar = this.calendars[i];
                                this.selectedCalendar = this.calendars[i];
                                this.currentPeriod = periods[j];
                                this.selectedPeriod = periods[j];
                                this.selectedYear = new Date(periods[j].start_date + 'T00:00:00').getFullYear();
                            }
                        }
                        if (this.currentCalendar)
                            break;
                    }
                    this.periodsYears();
                },
                periodsYears() {
                    // filtrar los periodos del calendario seleccionado para el año del periodo actual
                    this.periods = this.selectedCalendar.periods.filter((item) => {
                        return new Date(item.start_date + 'T00:00:00').getFullYear() === new Date(this.currentPeriod.start_date + 'T00:00:00').getFullYear()
                            || this.selectedCalendar.frequency === 'yearly';
                    });

                    // Lista de años del calendario seleccionado
                    let start = new Date(this.selectedCalendar.start_date + 'T00:00:00').getFullYear();
                    let end = new Date(this.selectedCalendar.end_date + 'T00:00:00').getFullYear();
                    this.years = Array(end - start + 1).fill().map((_, idx) => start + idx);
                },
                selectCalendar() {
                    this.periodsYears();

                    // Re-inicia el periodo y el año seleccionado de acuerdo al calendario seleccionado
                    for (let i = 0; i < this.periods.length; i++) {
                        if (this.currentPeriod.parents.map(({parent_id}) => parent_id).includes(this.periods[i].id)) {
                            this.selectedPeriod = this.periods[i];
                            this.selectedYear = new Date(this.periods[i].start_date + 'T00:00:00').getFullYear();
                            return;
                        }
                    }
                    //TODO seleccionar periodo cuando el actual es de calendario mayor
                    // si los periodos del calendario seleccionado no tienen hijos, se reinicia al periodo actual
                    this.selectedPeriod = this.currentPeriod;
                    this.selectedYear = new Date(this.currentPeriod.start_date + 'T00:00:00').getFullYear();
                },
                selectYear() {
                    // filtrar los periodos del calendario seleccionado para el año seleccionado
                    this.periods = this.selectedCalendar.periods.filter((item) => {
                        return new Date(item.start_date + 'T00:00:00').getFullYear() === this.selectedYear;
                    });

                    // Selecciona el periodo del calendario de acuerdo al año
                    for (let i = 0; i < this.periods.length; i++) {
                        if (this.periods[i].name === this.selectedPeriod.name) {
                            this.selectedPeriod = this.periods[i];
                            return;
                        }
                    }
                },
                apply() {
                    this.open = false;
                    this.currentPeriod = this.selectedPeriod;
                    this.currentPeriodId = this.selectedPeriod.id;
                    this.currentCalendar = this.selectedCalendar;

                    this.$wire.showResults(this.currentPeriodId);
                },
                move(step) {
                    for (let i = 0; i < this.currentCalendar.periods.length; i++) {
                        if (this.currentCalendar.periods[i].id === this.currentPeriodId) {
                            this.currentPeriod = this.currentCalendar.periods[i + step]
                            this.currentPeriodId = this.currentPeriod.id;
                            break;
                        }
                    }
                    this.$wire.showResults(this.currentPeriodId);
                },
                canMove(step) {
                    if (step === -1)
                        return this.currentCalendar.periods[0].id === this.currentPeriodId;

                    return this.currentCalendar.periods[this.currentCalendar.periods.length - 1].id === this.currentPeriodId;
                }
            }))
        })
    </script>
@endpush