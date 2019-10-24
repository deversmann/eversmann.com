---
layout: post
title:  "Reposting For A Friend"
description:
comments: false
keywords:
---

About a year ago (2018-10-26), an associate of mine published a really good blog post about automation and job security.  It was one of my favorite posts on the subject.  I discovered recently that his blog had disappeared, so I'm going to repost it here for now.

* * * * *

Settle down Jerry… Automation isn’t Taking your Job
===================================================

by Bill Hirsch
--------------


<p>I have encountered reluctance among my customers to automate some of the everyday operations and development tasks
    that we’ve all been doing for years in information technology roles.  Things like, building a new VM, deploying
    code, installing software, patching, adding VLANs, etc.  You know, the typical stuff.  At first, I didn’t take the
    objection very seriously because I honestly didn’t get it, but over time I’ve come to understand that this is a real
    concern for some in IT.  Now, just to be clear, the type of automation I’m talking about is IT automation with tools
    like Ansible, Puppet, Chef, or Salt.   I’m not talking about the robots… they <em>ARE</em> kind of scary… especially
    those dog-looking ones.</p>
<div></div>
<p>So, for the purpose of this article, you can assume I’m referencing basic IT automation that still requires human
    interaction.  In that context, humor me while I walk you through an elementary school-style test.</p>
<div></div>
<p><em><strong>Jerry and Karen have been asked by their boss, Mrs. Iminchargeofstuff to perform a task.  She needs it
            done quickly and it needs to be repeatable.</strong></em></p>
<div></div>
<p>“Hey Jerry and Karen!  I need a RHEL VM built in AWS.  I need that VM to have a public IP address, and it will
    resolve to someurl.  Then, I need you to add a iminchargeofstuff user account, and install a number of software
    packages. Make sure you can build it the exact same way over and over again.”</p>
<div></div>
<p>So, what skills will Jerry need to complete this task?</p>
<ul>
    <li>Jerry needs to know RHEL.  He needs to understand how to install RHEL, add users to RHEL, and add packages to
        RHEL</li>
    <li>Jerry needs to know AWS.  He needs to know how to create a public IP address on a new AWS instance, he needs to
        know how to add that instance &amp; IP to route53.</li>
</ul>
<div></div>
<div>What skills does Karen need to complete this task?</div>
<ul>
    <li>Karen need to know Ansible (yes, yes, i know there are others, but Ansible is awesome so deal with it).</li>
</ul>
<p>Once Karen writes these tasks into an Ansible Playbook, will Jerry’s skills still be required and why?</p>
<div></div>
<ul>
    <li>(exasperated nerd voice) YES!!!! Because Karen doesn’t know anything about RHEL or AWS.  What if Mrs.
        Iminchargeofstuff decides that she wants the playbook to include adding an AWS subnet.  Karen doesn’t know AWS
        so she wouldn’t understand how to add a subnet in AWS.  Knowing Ansible isn’t going to magically fix that.</li>
</ul>
<div></div>
<p>So, this all shakes out a bit like this.  Even if you master an automation tool like Ansible, you still need to have
    skills in the underlying technology you are automating.  If you write a playbook to automate a network switch, you
    will have to understand networking.  If you write a playbook to install a customer application, you will need to
    know that application’s prerequisites.  If you write a playbook to patch an operating system, you have to know that
    operating system.</p>
<div></div>
<p><strong>Using automation to do you job safer and faster does not threaten your job security…
        it ensures it.</strong><br />
     </p>
<p> </p>
