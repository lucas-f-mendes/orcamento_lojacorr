<?php

class Budget
{
    public function __construct(
        private array $houses = array(),
        private int $quantity = 0,
        private int $amount = 0,
        private int $initial_budget = 0,
        private int $current_budget = 0
    ) {
    }

    protected function getHouses(): array
    {
        return $this->houses;
    }

    protected function setHouses($houses): void
    {
        $this->houses = $houses;
    }

    protected function getQuantity(): int
    {
        return (int) $this->quantity;
    }

    protected function setQuantity($quantity): void
    {
        $this->quantity = (int) $quantity;
    }

    protected function getAmount(): int
    {
        return (int) $this->amount;
    }

    protected function setAmount($amount): void
    {
        $this->amount = (int) $amount;
    }

    protected function getInitialBudget(): int
    {
        return (int) $this->initial_budget;
    }

    protected function setInitialBudget($initial_budget): void
    {
        $this->initial_budget = (int) $initial_budget;
    }

    protected function getCurrentBudget(): int
    {
        return (int) $this->current_budget;
    }

    protected function setCurrentBudget($current_budget): void
    {
        $this->current_budget = (int) $current_budget;
    }

    public function getMaxHouses($budget): void
    {
        if (!is_numeric($budget)) {
            echo "Valor inválido";
            return;
        }

        $this->setInitialBudget($budget);
        $this->setCurrentBudget($budget);

        $prices = $this->getHousePrices();
        sort($prices);

        foreach ($prices as $price) {
            $current_budget = $this->getCurrentBudget();
            $quantity = $this->getQuantity();
            $houses = $this->getHouses();
            $total = $this->getAmount();

            if ($price <= $current_budget) {
                $current_budget -= $price;
                $total += $price;
                $quantity++;
                $houses[] = $price;

                $this->setCurrentBudget($current_budget);
                $this->setAmount($total);
                $this->setQuantity($quantity);
                $this->setHouses($houses);
            }
        }

        $this->getMessages();
    }

    private function getMessages(): void
    {
        $quantity_houses = count($this->getHousePrices());
        $budget = $this->getInitialBudget();
        $quantity = $this->getQuantity();
        $amount = $this->getAmount();
        $balance = $this->getCurrentBudget();

        $formatted_budget = $this->formatMoney($budget);
        $formatted_amount = $this->formatMoney($amount);
        $formatted_balance = $this->formatMoney($balance);

        echo "-------------------------------------------- \n";

        echo "Na região existem $quantity_houses casas \n";
        echo "Seu orçamento disponivel é de $formatted_budget \n";
        if ($quantity >= 1) {
            echo "Com esse valor, você pode adquirir $quantity casas, com um total de $formatted_amount \n";
            echo "E por fim, seu saldo é de $formatted_balance \n";
        } else {
            echo "Com esse valor não é possivel adquir uma casa :( \n";
        }

        echo "--------------------------------------------";

        $this->restartApp();
    }

    private function getHousePrices(): array
    {
        return array(
            250000, //R$250.000
            400000, //R$400.000
            150000, //R$150.000
            1000000, //R$1.000.000
        );
    }

    private function formatMoney($value)
    {
        return "R$" . number_format($value, 2, ",", ".");
    }

    private function restartApp()
    {
        echo "\n Qual o seu orçamento? ";
        fscanf(STDIN, "%s\n", $value);

        $this->getMaxHouses($value);
    }
}

echo "Qual o seu orçamento? ";
fscanf(STDIN, "%s\n", $value);

$budget = new Budget;
$budget->getMaxHouses($value);
