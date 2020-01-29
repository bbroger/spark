let currentHref;
let parent;

function onDeleteConfirm()
{
  const el = $(this);

  el.html('<i class="fas fa-spinner fa-spin"></i>');

  $.ajax({
    type: 'DELETE',
    url: currentHref,
    success: () => {
      currentHref = null;
      el.html('Sim');
      parent.remove();
      $('#delete-modal').modal('hide');
    }
  });
}

function onDeleteButtonClick(e)
{
  e.preventDefault();

  const el = $(this);

  $('#delete-modal').modal();
  $('#delete-modal-message').html(el.data('delete-message'));

  currentHref = el.attr('href');
  parent = el.parent().parent();

  return false;
}

$('a.btn-delete').click(onDeleteButtonClick);
$('#delete-modal-confirm').click(onDeleteConfirm);