            <div class="product-details clearfix">
                <div class="row">
                    <div class="col-md-6">

                        <div class="product-status product-status-{$rawstatus|strtolower}">
                            <div class="product-icon text-center">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
                                </span>
                                <h3>{$product}</h3>
                                <h4>{$groupname}</h4>
                            </div>
                            <div class="product-status-text">
                                {$status}
                            </div>
                        </div>

                        {if $showcancelbutton || $packagesupgrade}
                            <div class="row">
                                {if $packagesupgrade}
                                    <div class="col-xs-{if $showcancelbutton}6{else}12{/if}">
                                        <a href="/upgrade.php?type=package&amp;id={$id}" class="btn btn-block btn-success">{$LANG.upgrade}</a>
                                    </div>
                                {/if}
                                {if $showcancelbutton}
                                    <div class="col-xs-{if $packagesupgrade}6{else}12{/if}">
                                        <a href="/clientarea.php?action=cancel&amp;id={$id}" class="btn btn-block btn-danger {if $pendingcancellation}disabled{/if}">{if $pendingcancellation}{$LANG.cancellationrequested}{else}{$LANG.clientareacancelrequestbutton}{/if}</a>
                                    </div>
                                {/if}
                            </div>
                        {/if}

                    </div>
                    <div class="col-md-6 text-center">

                        <h4>{$LANG.clientareahostingregdate}</h4>
                        {$regdate}

                        <h4>{$LANG.serverusername}</h4>
                        {$username}

                        {if $firstpaymentamount neq $recurringamount && $billingcycle neq 'Free Account'}
                            <h4>{$LANG.firstpaymentamount}</h4>
                            {$firstpaymentamount}
                        {/if}

                        {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree && $billingcycle neq 'Free Account'}
                            <h4>{$LANG.recurringamount}</h4>
                            {$recurringamount}
                        {/if}

                        {if $billingcycle neq 'Free Account'}
                            <h4>{$LANG.orderbillingcycle}</h4>
                            {$billingcycle}

                            <h4>{$LANG.clientareahostingnextduedate}</h4>
                            {$nextduedate}

                            <h4>{$LANG.orderpaymentmethod}</h4>
                            {$paymentmethod}
                        {/if}

                        {if $suspendreason}
                            <h4>{$LANG.suspendreason}</h4>
                            {$suspendreason}
                        {/if}

                    </div>
                </div>
            </div>
{foreach from=$configurableoptions item=configoption}
    <div class="row">
        <div class="col-sm-5 text-right">
            {$configoption.optionname}
        </div>
        <div class="col-sm-7">
            {if $configoption.optiontype eq 3}
                {if $configoption.selectedqty}
                    {$LANG.yes}
                {else}
                    {$LANG.no}
                {/if}
            {elseif $configoption.optiontype eq 4}
                {$configoption.selectedqty} {if $configoption.selectedqty eq '1'}{$configoption.selectedoption|rtrim:'s'}{else}{$configoption.selectedoption}{/if}
            {else}
                {$configoption.selectedoption}
            {/if}
        </div>
    </div>
{/foreach}

{foreach from=$productcustomfields item=customfield}
    <div class="row">
        <div class="col-sm-5">
            {$customfield.name}
        </div>
        <div class="col-sm-7">
            {$customfield.value}
        </div>
    </div>
{/foreach}