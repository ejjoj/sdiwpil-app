<template>
  <v-row>
    <v-col
      md="4"
      cols="auto"
    >
      <v-card
        class="text-center"
        color="green"
        dark
      >
        <v-card-text>
          <v-sheet color="rgba(0, 0, 0, .12)">
            <v-sparkline
              :value="appointments"
              color="rgba(255, 255, 255, .7)"
              height="100"
              padding="24"
              stroke-linecap="round"
              smooth
            >
              <template #label="item">
                {{ item.value }}
              </template>
            </v-sparkline>
          </v-sheet>
        </v-card-text>

        <v-card-text>
          <div class="text-h4 font-weight-thin">
            Rejestracja wizyt w ostatnich 24h
          </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="justify-center">
          <v-btn
            block
            text
          >
            Zobacz raport
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col
      md="4"
      cols="auto"
    >
      <v-card
        class="text-center"
        color="accent"
        dark
      >
        <v-card-text>
          <v-sheet color="secondary">
            <v-sparkline
              :value="registeredUsers"
              color="white"
              height="100"
              padding="24"
              stroke-linecap="round"
              smooth
            >
              <template #label="item">
                {{ item.value }}
              </template>
            </v-sparkline>
          </v-sheet>
        </v-card-text>

        <v-card-text>
          <div class="text-h4 font-weight-thin">
            Zarejestrowani użytkownicy w ostatnich 24h
          </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="justify-center">
          <v-btn
            block
            text
          >
            Zobacz raport
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col
      md="4"
      cols="auto"
    >
      <v-card
        class="text-center"
        color="secondary"
        dark
      >
        <v-card-text>
          <v-sheet color="accent">
            <v-sparkline
              :value="sales"
              color="white"
              height="100"
              padding="24"
              stroke-linecap="round"
              smooth
            >
              <template #label="item">
                {{ item.value }}
              </template>
            </v-sparkline>
          </v-sheet>
        </v-card-text>

        <v-card-text>
          <div class="text-h4 font-weight-thin">
            Sprzedaż w ostatnich 24h
          </div>
        </v-card-text>

        <v-divider />

        <v-card-actions class="justify-center">
          <v-btn
            block
            text
          >
            Zobacz raport
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'StatisticsChart',
  data: () => ({
    appointments: [
      423,
      446,
      675,
      510,
      590,
      610,
      760,
    ],
    registeredUsers: [
      675,
      610,
      760,
      446,
      423,
      510,
      590,
    ],
    sales: [
      675,
      610,
      1258,
      120,
      423,
      2138,
      590,
    ],
  }),
};
</script>

<style scoped>

</style>
